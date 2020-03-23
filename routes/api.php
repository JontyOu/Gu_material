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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::match(['post', 'get'], 'hello', function () {
    return 'hello.world,post';
});
Route::redirect('hi', 'hello');

Route::namespace('Api\v1')->prefix('v1')->group(function () {
    Route::get('index','IndexController@index');
    Route::get('show','IndexController@show');
});
