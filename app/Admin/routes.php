<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->any('/', 'HomeController@index');
    //用户表
    $router->resource('/users', 'UserController');
    //门店列表
    $router->resource('/shops', 'ShopController');
    //行业
    $router->resource('/trades', 'TradeController');
    //岗位
    $router->resource('/positions', 'PositionController');
    //特殊区域
    $router->resource('/areas', 'AreaController');
    //工作订单
    $router->resource('/orders', 'OrderController');
    //标签列表
    $router->resource('/tags', 'TagController');
    //评价列表
    $router->resource('/marks', 'MarkController');

});
