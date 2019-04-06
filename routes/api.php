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

// 登录相关
Route::post('login', 'Auth\LoginController@login');
Route::all('oauth/weapp/code', 'OauthController@weapp');
Route::post('login/oauth/weapp', 'LoginController@loginByWeappOpenid');
Route::post('login/weapp', 'LoginController@loginWithOpenid');

// 读书会相关
Route::get('book-party/list', 'BookPartyController@list');
Route::get('book-party/detail', 'BookPartyController@detail');

// 管理员相关
Route::middleware('admin')->group(function () {
    Route::post('book-party/add', 'BookPartyController@add');
    Route::post('book-party/update', 'BookPartyController@update');
    Route::post('book-party/delete', 'BookPartyController@delete');
});

// 需要登录的控制器
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return RJM(0, $request->user());
    });
    Route::post('user/book-party/sign-up', 'BookPartyController@getSignupListByUser');
    Route::post('user/book-party/check-in', 'BookPartyController@getCheckinListByUser');
    Route::post('book-party/sign-up', 'BookPartyController@signup');
    Route::post('book-party/check-in', 'BookPartyController@checkin');
});

// 找不到路由的兜底
Route::fallback('Controller@notFound');