<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('admin',function (){
    return view('admin');
});
Route::get('details',function (){
    return view('details');
});
//管理员登录
Route::get('login',function (){
    return view('login');
});
Route::get('readings',function (){
    return view('readings');
});

//登录
Route::post('api/admin/login','Auth\LoginController@adminLogin');
//显示所有管理员
Route::get('api/admin/show','AdminController@showAdmin');
//显示当前读书会报名人员
Route::get('api/bookParty/showSignUp/{id}','BookPartyController@showSignUp');
//显示所有读书会的所有内容
Route::get('api/bookParty/list','BookPartyController@showReadParty');
//新建读书会
Route::post('api/bookParty/add','BookPartyController@add');
//删除读书会
Route::post('api/bookParty/delete','BookPartyController@delete');
//选择一个读书会
Route::get('api/bookParty/select/{id}','BookPartyController@select');
//更改读书会内容
Route::post('api/bookParty/update','BookPartyController@update');