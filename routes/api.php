<?php

use Illuminate\Http\Request;
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

Route::middleware('cors')->group(function () {
    // 登录相关
    Route::post('login', 'Auth\LoginController@login');
    Route::post('admin/login','Auth\LoginController@adminLogin');
    Route::any('oauth/weapp/code', 'Auth\OauthController@weapp');
    Route::post('login/oauth/weapp', 'Auth\LoginController@loginByWeappOpenid');
    Route::post('login/weapp', 'Auth\LoginController@loginWithCode');

    // 读书会相关
    Route::get('book-party/list', 'BookPartyController@list');
    Route::get('book-party/detail', 'BookPartyController@detail');

    // 学院相关
    Route::get('institute/list', 'InstituteController@list');


    // 管理员相关
    Route::middleware('admin')->group(function () {
        Route::get('admin/show','AdminController@showAdmin');
        Route::post('book-party/add', 'BookPartyController@add');
        Route::post('book-party/update', 'BookPartyController@update');
        Route::post('book-party/delete', 'BookPartyController@delete');
        Route::get('book-party/showSignUp/{id}','BookPartyController@showSignUp');
        Route::get('book_party/showCheckIn/{id}','BookPartyController@showCheckIn');

    });

    // 需要登录的控制器
    Route::middleware('auth:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return RJM(0, $request->user());
        });
        Route::get('user/book-party/sign-up', 'BookPartyController@getSignupListByUser');
        Route::get('user/book-party/check-in', 'BookPartyController@getCheckinListByUser');
        Route::post('book-party/sign-up', 'BookPartyController@signup');
        Route::post('book-party/check-in', 'BookPartyController@checkin');
        Route::post('user/user-info', 'UserController@updateUserInfo');
    });
});

// 找不到路由的兜底
Route::fallback('Controller@notFound');

