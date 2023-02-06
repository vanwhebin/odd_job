<?php

use App\Jobs\DeleteFile;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Api')
        ->prefix('api')  //本地调试打开
//    ->domain(config('services.api_domain')) //线上时打开
    ->group(function () {
        //用户登录
        Route::post('/users', 'UserController@login')->name('users.login');
        // 短信验证码
        Route::post('verificationcodes', 'VerificationCodesController@store')->middleware('throttle:sms')
            ->name('users.verificationcodes.store');

        //*******************************  岗位  *************************************
        //岗位列表
        Route::get('positions', 'PositionController@index')->name('positions.index');

//        //微信支付
//        Route::get('payment/{order}/wechat', 'PaymentController@payByWechat')->name('payment.wechat');
//        //微信支付回調地址
//        Route::any('payment/wechat/notify', 'PaymentController@wechatNotify')->name('payment.wechat.notify');
//        //支付宝支付
//        Route::get('payment/{order}/ali', 'PaymentController@payByAli')->name('payment.ali');
//        //支付宝回调地址
//        Route::any('payment/ali/notify', 'PaymentController@alipayNotify')->name('payment.ali.notify');

        Route::post('/test', function(){
            $user= \App\Models\User::find(1);
            //5分钟没有使用即删除该图片
            dd($user);
           dd($user->shop);
        });
        //需登录的接口
        Route::group([
            'middleware' => [
//                'token.refresh',
                'api.auth',
//                'last_actived_time'
            ]
        ],
            function () {
                //图像上传，头像
                Route::post('images', 'ImagesController@store')->name('images.store');

                //当前用户信息
                Route::get('users', 'UserController@index')->name('users.info');
                //获取手机号码
                Route::post('users/phone', 'UserController@getPhone')->name('users.getPhone');


                //*******************************  门店  *************************************
                //注册门店
                Route::post('shops', 'ShopController@store')->name('shops.store');
                //我的所有门店列表
                Route::get('shops', 'ShopController@index')->name('shops.index');
                //我的注册门店信息
                Route::get('shops/{user}', 'ShopController@show')->name('shops.show');

                //*******************************  工作订单  *************************************
                //发布工作
                Route::post('orders', 'OrderController@store')->name('orders.store');
                //订单列表
                Route::get('orders', 'OrderController@index')->name('orders.index');
                //未付款订单付款详情
                Route::get('orders/{order}/pay_info', 'OrderController@payInfo')->name('orders.payInfo');


            });
    });

