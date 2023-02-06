<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Yansongda\Pay\Pay;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        // Yansongda\Pay   微信支付
        $this->app->singleton('wechat_pay', function () {
            $config = config('pay.wechat');
            $config['notify_url'] = route('payment.wechat.notify');
//            $config['notify_url'] = config('app.url') . '/payment/wechat/notify';

            if (app()->environment() == 'production') {
                $config['log']['level'] = Logger::INFO;
            } else {
                $config['log']['level'] = Logger::DEBUG;
            }
            // 调用 Yansongda\Pay 来创建一个微信支付对象
            return Pay::wechat($config);
        });
        // Yansongda\Pay   支付宝支付
        $this->app->singleton('ali_pay', function () {
            $config = config('pay.alipay');
            $config['notify_url'] = route('payment.ali.notify');
//            $config['notify_url'] = 'http://g853xv.natappfree.cc/api/payment/alipay/notify';
            //跳回订单详情
            $config['return_url'] = config('services.h5_url') . '/pages/index/success';
//            $config['return_url'] = 'http://192.168.0.65:8081/pages/index/success';
            if (app()->environment() == 'production') {
                $config['log']['level'] = Logger::INFO;
            } else {
                $config['log']['level'] = Logger::DEBUG;
            }
            // 调用 Yansongda\Pay 来创建一个支付宝支付对象
            return Pay::alipay($config);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Relation::enforceMorphMap([
            'shop' => 'App\Models\Shop',
        ]);
        //sql 日志
        if (config('services.sql_log')) {

            if (!strpos(request()->getRequestUri(), 'telescope') && !app()->environment('production')) {
                Log::info('⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩   ' . request()->method() . '   |  ' . request()->fullUrl() . '   ⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩⇩');
            }
            DB::listen(function (QueryExecuted $query) {
                $duration = $this->formatDuration($query->time / 1000);
                $sqlWithPlaceholders = str_replace(['%', '?'], ['%%', '%s'], $query->sql);
                $bindings = $query->connection->prepareBindings($query->bindings);
                $pdo = $query->connection->getPdo();
                $realSql = vsprintf($sqlWithPlaceholders, array_map([$pdo, 'quote'], $bindings));
                if (!strpos(request()->getRequestUri(), 'telescope') && !strpos($realSql, 'telescope') && $duration) {
                    if (!strpos(request()->getRequestUri(), 'telescope') && app()->environment('production')) {
                        Log::info('=========   ' . request()->method() . '   |  ' . request()->fullUrl() . '   ===============');
                    }
                    Log::debug(sprintf('[%s] %s ', $duration, $realSql));
                }
            });
        }
    }

    private function formatDuration($seconds)
    {
        if ($seconds < 0.001) {
            //return round($seconds * 1000000) . 'μs';
            return false;
        } elseif ($seconds < 1) {
            //return round($seconds * 1000, 2) . 'ms';
            if (round($seconds * 1000, 2) > config('services.slow_sql')) {
                return round($seconds * 1000, 2) . 'ms';
            } else {
                return false;
            }
        }
        return round($seconds, 2) . 's';
    }
}
