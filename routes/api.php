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

Route::post('login', 'Auth\LoginController@login');
Route::get('book-party/list', 'BookPartyController@list');

Route::middleware('admin')->group(function () {
    Route::post('book-party/add', 'BookPartyController@add');
});
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return RJM(0, $request->user());
    });
    Route::post('book-party/add', 'BookPartyController@add');
});

Route::fallback('Controller@notFound');