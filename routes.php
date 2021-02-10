<?php

use Illuminate\Routing\Router;

// 接口
Route::group([
    'prefix' => 'scan-recharge',
    'namespace' => 'Qihucms\ScanRecharge\Controllers\Wap',
    'middleware' => ['web', 'auth'],
    'as' => 'wap.scan.recharge.'
], function (Router $router) {
    $router->get('recharge', 'RechargeController@index')->name('index');
    $router->get('log', 'RechargeController@log')->name('log');
    $router->post('recharge', 'RechargeController@store');
});

// 后台管理
Route::group([
    'prefix' => config('admin.route.prefix') . '/scan-recharge',
    'namespace' => 'Qihucms\ScanRecharge\Controllers\Admin',
    'middleware' => config('admin.route.middleware'),
    'as' => 'admin.scan.recharge'
], function (Router $router) {
    $router->resource('channels', 'ChannelController');
    $router->resource('orders', 'OrderController');
});