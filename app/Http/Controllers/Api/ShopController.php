<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ShopResource;
use App\Http\Resources\Api\ShopResourceCollection;
use App\Jobs\DeleteFile;
use App\Models\Image;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();
        $shops = $user->relateShops ?? collect([]);
        $shops = $shops->merge([$user->shop]);

        $shops->loadMissing([
            'certImage:id,path,imagetable_id,imagetable_type,detail',
            'shopImage:id,path,imagetable_id,imagetable_type,detail',
        ]);
        return ShopResourceCollection::make($shops)->additional([
            'code' => 200,
            'status' => "success",
        ]);
    }

    public function store(Request $request, Shop $shop)
    {
        $validator = Validator::make($request->all(), [
            'real_name' => 'required|string',
            'ID_card_no' => 'required|numeric',
            'shop_name' => 'required|string',
            'type' => 'required|in:1,2',
            'province' => 'required|string',
            'province_id' => 'required|numeric',
            'city' => 'required|string',
            'city_id' => 'required|numeric',
            'area' => 'required|string',
            'area_id' => 'required|numeric',
            'address' => 'required|string',
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|166|(17[0,3,5-8])|(18[0-9])|(19[0-9]))\d{8}$/',
            ],
            'captcha' => 'nullable|string',
            'verification_key' => 'nullable|string',
            'cert' => 'nullable|array',
            'cert.id' => 'required|exists:images,id',
            'shop' => 'nullable|array',
            'shop.id' => 'nullable|exists:images,id',
        ],
            [
                'cert.id.exists' => '营业执照图片已过期，请重新上传',
                'shop.id.exists' => '门店照片已过期，请重新上传',
            ],
            [
                'real_name' => '姓名',
                'ID_card_no' => '身份证号',
                'shop_name' => '店铺名称',
                'type' => '行业分类',
                'province' => '省份',
                'province_id' => '省份编码',
                'city' => '城市编码',
                'city_id' => '城市编码',
                'area' => '区域编码',
                'area_id' => '区域编码',
                'address' => '详细地址',
                'phone' => '手机号',
                'captcha' => '验证码',
                'cert' => '营业执照',
                'cert.id' => '营业执照',
                'shop' => '门店照片',
                'shop.id' => '门店照片',
            ]);
        if ($validator->fails()) {
            return $this->failed($validator->errors()->first());
        }
        $data = $validator->validated();
        $user = auth('api')->user();
        if ($request->verification_key) {
            $verifyData = cache()->get($request->verification_key);
            if (!$verifyData) {
                return $this->failed('验证码已失效');
            }
            if (!hash_equals((string)$verifyData['code'], $request->captcha)) {
                return $this->failed('验证码错误');
            }
            // 清除验证码缓存
            cache()->forget($request->verification_key);
            $temp_user = Shop::where('id', '<>', $user->id)
                ->where('phone', $verifyData['phone'])
                ->first();
            if ($temp_user) {
                return $this->failed('该手机号已被其它用户占用，请更改手机号');
            }
        }
        DB::beginTransaction();
        try {

            $data['user_id'] = $user->id;
            unset($data['address_name']);
            if (!empty($data['city_id']) && strlen($data['city_id']) != 6) {
                $data['city_id'] .= '00';
            }
            if (!empty($data['province_id']) && strlen($data['province_id']) != 6) {
                $data['province_id'] .= '0000';
            }
            if ($user->shop) {
                $shop = $user->shop;
                //更新时去除原来的图片
                if ($shop->certImage) {
                    $image = $shop->certImage;
                    $image->imagetable_id = null;
                    $image->imagetable_type = null;
                    $image->detail = 0;
                    $image->save();
                    dispatch(new DeleteFile($image))->afterCommit();
                }
                if ($shop->shopImage) {
                    $image = $shop->shopImage;
                    $image->imagetable_id = null;
                    $image->imagetable_type = null;
                    $image->detail = 0;
                    $image->save();
                    dispatch(new DeleteFile($image))->afterCommit();
                }
                $data['status'] = 0;
                $shop->update($data);
                $shop->save();
            } else {
                $shop->fill($data);
                $shop->save();
            }
            if (!empty($data['cert']['id'])) {
                $image = Image::find($data['cert']['id']);
                if (!$image) {
                    DB::rollBack();
                    return $this->failed('营业执照图片已过期，请重新上传');
                }
                $image->detail = 1;
                $image->save();
                $shop->certImage()->save($image);
            }
            if (!empty($data['shop']['id'])) {
                $image = Image::find($data['shop']['id']);
                if (!$image) {
                    DB::rollBack();
                    return $this->failed('门店照片已过期，请重新上传');
                }
                $image->detail = 2;
                $image->save();
                $shop->shopImage()->save($image);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->failed($exception->getMessage());
        }
        return $this->success();
    }

    //我的门店
    public function show(User $user)
    {
        $shop = $user->shop->loadMissing([
            'certImage:id,path,imagetable_id,imagetable_type,detail',
            'shopImage:id,path,imagetable_id,imagetable_type,detail',
        ]);
        return ShopResource::make($shop)->additional([
            'code' => 200,
            'status' => "success",
        ]);
    }
}
