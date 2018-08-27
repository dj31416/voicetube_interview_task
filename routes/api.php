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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//Route::resource('list','ListController');



Route::get('list/{id?}','ListController@show');
Route::post('list/create/{token}','ListController@create');
Route::put('list/update/{id}/{token}','ListController@update');
Route::delete('list/delete/{id}/{token}','ListController@delete');
Route::delete('list/deleteAll/{token}','ListController@deleteAll');



Route::get('token','TokenController@index');
Route::get('token/renew/{old_token}/{renew_token}','TokenController@renew');
Route::get('token/status/{token}','TokenController@status');



