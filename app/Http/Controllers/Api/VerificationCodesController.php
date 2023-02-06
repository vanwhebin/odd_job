<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    //短信发送验证码
    public function store(Request $request, EasySms $easySms)
    {
        $validator = Validator::make($request->all(), [
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|166|(17[0,3,5-8])|(18[0-9])|(19[0-9]))\d{8}$/',
            ],
        ], [], [
            'phone' => '手机号',
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors()->first());
        }
        $phone = $request->phone;

        if (!app()->environment('production')) {
            $code = '1234';
        } else {
            // 生成4位随机数，左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            try {
                $easySms->send($phone, [
                    //'content'  =>  "【签名】您的验证码：{$code}，如非本人操作，请忽略。",
//                    'template' => 'SMS_256070379',
                    'data' => [
                        "code" => $code,
                    ],
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $result = $exception->getException('aliyun');
                $code = $result->getCode();
                $statusMsg = $result->raw['Message'] ?? $code;
                \Log::debug('短信发送失败: ' . $phone . ' 失败原因: ' . $statusMsg,[$result]);
                return $this->failed($statusMsg);
            }
        }
        $key = 'verificationCode_' . Str::random(15);
        $expiredAt = now()->addMinutes(5);
        // 缓存验证码 10分钟过期。
        cache()->put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return $this->success([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ]);
    }
}
