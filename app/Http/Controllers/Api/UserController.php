<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResources;
use App\Jobs\PerfectUserParent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class UserController extends Controller
{
    //用户信息
    public function index()
    {
        $user = auth('api')->user();
        return UserResources::make($user)->additional([
            'code' => 200,
            'status' => "success",
        ]);
    }

    //获取用户微信信息
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'iv' => 'required|string',
            'encryptedData' => 'required|string',
            'code' => 'required_without:session_key|nullable|string',
            'session_key' => 'required_without:code|nullable|string',
            'parent_uuid' => 'nullable|string',
        ], [
            'code.required_without' => '微信参数出错',
            'session_key.required_without' => '微信参数出错',
            'iv.required' => '加密算法的初始向量必填',
            'encryptedData.required' => '加密数据必填',
        ], []);
        if ($validator->fails()) {
            return $this->failed($validator->errors()->first(), 422);
        }
        $code = $request->code;
        $iv = $request->iv;
        $encryptedData = $request->encryptedData;
        try {
            $miniProgram = app('wechat.mini_program.default');
            //有session_key状态不需要code.
            if (!$request->session_key) {
                $data = $miniProgram->auth->session($code);
                Log::channel('error')->debug('没有参数  session_key,此时的 data', [$data]);
            } else {
                $data['session_key'] = $request->session_key;
                Log::channel('error')->debug('有参数  session_key,此时的 data', [$data]);
            }
            $oauthUser = $miniProgram->encryptor->decryptData($data['session_key'], $iv, $encryptedData);
        } catch (\Exception $e) {
            Log::channel('error')->debug('用户信息获取失败  ' . $e->getMessage(), [$data ?? []]);
            if (!app()->environment('production')) {
                return $this->failed($e->getMessage(), 422);
            } else {
                return $this->failed('用户信息获取失败,请重试！', 422);
            }
        }
        $user = User::where('weapp_openid', $oauthUser['openId'])->first();

        if ($request->parent_uuid) {
            $parent_id = current(Hashids::decode($request->parent_uuid));
            $parent = User::find($parent_id);
            if (!$parent) {
                return $this->failed('上级 UUID 出错,请重试！',);
            }
        }

        if (!$user) {
            $user = User::create([
                'name' => $oauthUser['nickName'],
                'avatar' => $oauthUser['avatarUrl'],
                'parent_id' => $parent_id ?? null,
                'weapp_openid' => $oauthUser['openId'] ?? '',
                'unionid' => $oauthUser['unionid'] ?? '',
                "status" => 1,
            ]);
            //修复用户上级及上级门店
            dispatch(new PerfectUserParent($user));
        }

        if (!$user->weapp_openid) {
            $user->update([
                'weapp_openid' => $data['openid'] ?? '',
                'weixin_unionid' => $data['unionid'] ?? '',
            ]);
        }
        $token = Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token, [
            'session_key' => $data['session_key']
        ]);
    }

    //获取手机号码
    public function getPhone(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'iv' => 'required|string',
            'encryptedData' => 'required|string',
            'code' => 'required_without:session_key|nullable|string',
            'session_key' => 'required_without:code|nullable|string',
        ], [
            'code.required_without' => '微信参数出错',
            'session_key.required_without' => '微信参数出错',
            'iv.required' => '加密算法的初始向量必填',
            'encryptedData.required' => '加密数据必填',
        ], []);
        if ($validator->fails()) {
            return $this->failed($validator->errors()->first(), 422);
        }
        $code = $request->code;
        $iv = $request->iv;
        $encryptedData = $request->encryptedData;
        try {
            $miniProgram = app('wechat.mini_program.default');
            //有session_key状态不需要code.
            if (!$request->session_key) {
                $data = $miniProgram->auth->session($code);
                Log::channel('error')->debug('没有参数  session_key,此时的 data', [$data]);
            } else {
                $data['session_key'] = $request->session_key;
                Log::channel('error')->debug('有参数  session_key,此时的 data', [$data]);
            }
            $oauthUser = $miniProgram->encryptor->decryptData($data['session_key'], $iv, $encryptedData);
        } catch (\Exception $e) {
            Log::channel('error')->debug('用户信息获取失败  ' . $e->getMessage(), [$data ?? []]);
            if (!app()->environment('production')) {
                return $this->failed($e->getMessage(), 422);
            } else {
                return $this->failed('用户信息获取失败,请重试！', 422);
            }
        }
        return $this->success( [
            'phone' => $oauthUser['purePhoneNumber']
        ]);
    }

    //用户退出
    public function logout()
    {
        Auth::guard('api')->logout();
        return $this->success('退出成功...');
    }

    //返回 token
    protected function respondWithToken($token, $meta = [])
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ];
        if ($meta) {
            $data = array_merge($data, $meta);
        }
        return $this->success($data);
    }
}
