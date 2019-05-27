<?php

use Illuminate\Http\Request;

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


//Route::prefix('v1')->group(function () {
//    //无需验证access_token
//    Route::get('/user/{user}','IndexController@index');
//
//    Route::post('sms','HelperController@sms');
//
//    //需要验证access_token
//    Route::group([
//        'middleware' => 'auth:api'
//    ], function() {
//        Route::post('/user/{user}','IndexController@show');
//    });
//
//});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware'=>'api.throttle',
], function($api) {

    //第一个分组--------------------------------------------------------------------------------------------
    $api->group([
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api){
        //短信验证码
        $api->post('getSmsCode', 'HelperController@getSmsCode')
            ->name('api.getSmsCode');

        // 图片验证码
        $api->post('captchas', 'HelperController@getCaptcha')
            ->name('api.getCaptcha');

        // 小程序登录授权
        $api->post('authorizations/login', 'UserController@store')
            ->name('api.authorizations.login');

    });








});


