<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderResource;
use App\Http\Resources\Api\OrderResourceCollection;
use App\Models\Mark;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request  $request)
    {
        $mark= Mark::create([
            'type_id'=>2,
            'user_id'=>1,
            'marked_user_id'=>2,
        ]);

        dd($mark);


        if($request->current==0){
            $status=[0,1];
        }elseif($request->current==1){
            $status=[2];
        }elseif($request->current==1){
            $status=[2];
            $rate=false;
        }else{
            $status=[3];
        }
        $orders = Order::when($request->current,function($query)use($request){
                return $query->where('status',$request->status);
            })
            ->when(isset($rate) && $rate===false,function($query){
                return $query->whereNull('rate');
            })
            ->latest()
            ->paginate(config('services.limit'));

        return OrderResourceCollection::make($orders)->additional([
            'code' => 200,
            'status' => "success",
        ]);
    }

    public function store(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'day_range' => 'required|array',
            'day_range.*' => 'required|date',
            'time_range' => 'required|array',
            'time_range.start' => 'required|date_format:"H:i"',
            'time_range.end' => 'required|date_format:"H:i"',
            'time_range.urgent' => 'nullable',
            'shop_id' => 'required|exists:shops,id',
            'position_id' => 'required|exists:positions,id',
            'amount' => 'required|in:1,2',
            'wage' => 'required|numeric',
            'low_price' => 'nullable|numeric',
            'meal' => 'required|in:0,1',//meal
            'sex' => 'required|in:0,1,2',
            'age' => 'required|in:0,1,2,3',
            'content' => 'nullable|string',
        ], [],
            [
                'day_range' => '工作日期',
                'day_range.*' => '工作日期',
                'time_range' => '工作时间',
                'time_range.start' => '开始时间',
                'time_range.end' => '结束时间',
                'time_range.urgent' => '是否加急',
                'shop_id' => '门店',
                'position_id' => '岗位',
                'amount' => '工作人数',
                'wage' => '时薪',
                'low_price' => '最低时薪',
                'meal' => '是否含餐',//meal
                'sex' => '性别要求',
                'age' => '年龄要求',
                'content' => '工作要求',
            ]);
        if ($validator->fails()) {
            return $this->failed($validator->errors()->first());
        }
        $data = $validator->validated();
        $user = auth('api')->user();
        $dayRange = collect($data['day_range'])->sort()->values();
        //工作天数
        $days = $dayRange->count();

        //活动的时期及时间
        $data['start_date'] = $dayRange[0];
        $data['end_date'] = $dayRange[$days - 1];
        $data['start_time'] = $data['time_range']['start'];
        $data['end_time'] = $data['time_range']['end'];

        //现在时间与开始时间差 小时
        $diffInHours = Carbon::now()->diffInHours($data['time_range']['start'], false);
        //现在时间与开始时间差 秒
        $diff = Carbon::now()->diffInSeconds($data['time_range']['start'], false);
        //开始时间与结束时间差 工作时长
//        $hours = Carbon::parse($data['time_range']['start'])->diffInHours($data['time_range']['end']);
        $hours = Carbon::parse($data['time_range']['start'])->diffInMinutes($data['time_range']['end']) / 60;
        //有当天订单时。需判断开始时间及加急单、时薪
        if ($dayRange[0] == Carbon::now()->toDateString()) {
            if ($days > 1) {
                return $this->failed("多天工作并有加急单,暂不支持发布跨天工作,建议每天发布");
            }
            //判断开始时间
            if ($diffInHours < 2) {
                return $this->failed('发布当天订单需选择2个小时以后');
            }
            //判断时薪价格
            if ($hours < 1.5) {
                $low_price = config('services.first_hour_price');
            } else if ($hours < 2.5) {
                $low_price = config('services.second_hour_price');
            } else {
                $low_price = config('services.third_hour_price');
            }
            if ($data['wage'] < $low_price) {
                return $this->failed('时薪价格过低，请调整到 ¥' . $low_price . ' 元以上');
            }
        } else if ($dayRange[0] == Carbon::tomorrow()->toDateString()) {
            //只有明天之后的订单时
            if ($days > 1 && $diff < 0) {
                return $this->failed("多天工作并有加急单,暂不支持发布跨天工作,建议每天发布");
            }
            if ($diff < 0) {
                //判断时薪价格
                if ($hours < 1.5) {
                    $low_price = config('services.first_hour_price');
                } else if ($hours < 2.5) {
                    $low_price = config('services.second_hour_price');
                } else {
                    $low_price = config('services.third_hour_price');
                }
                if ($data['wage'] < $low_price) {
                    return $this->failed('时薪价格过低，请调整到 ¥' . $low_price . ' 元以上');
                }
            } else {
                if ($data['wage'] < $data['low_price']) {
                    return $this->failed('时薪价格过低，请调整到 ¥' . $data['low_price'] . ' 元以上');
                }
            }
        } else {
            //只有后天之后订单时
            if ($data['wage'] < $data['low_price']) {
                return $this->failed('时薪价格过低，请调整到 ¥' . $data['low_price'] . ' 元以上');
            }
        }

        $total = mul(mul($hours, $data['wage']), $days);
        $data['total'] = $total;

        DB::beginTransaction();
        try {
            $data['user_id'] = $user->id;
            $data['no'] = Order::findAvailableNo();
            $order->fill($data);
            $order->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->failed($exception->getMessage());
        }
        return $this->success([
            'order_id' => $order->id,
            'order_no' => $order->no,
            'total' => $order->total,
        ]);
    }

    public function show(Order $order)
    {
        return OrderResource::make($order)->additional([
            'code' => 200,
            'status' => "success",
        ]);
    }

    //未付款订单付款详情
    public function payInfo(Order $order)
    {
        $user = auth('api')->user();
        if ($user->id != $order->user_id) {
            return $this->failed('暂无权限');
        }
        $shop = $order->shop;
        return $this->success([
            'parent_store_flag' => $shop->parentShop ? true : false,
            'parent_store_wallet' => $shop->parentShop->wallet ?? '0.00',
            'wallet' => $shop->wallet,
            'shop_id' => $shop->id,
            'no' => $order->no,
            'total' => $order->total,
            'status' => $order->status,
        ]);
    }
}
