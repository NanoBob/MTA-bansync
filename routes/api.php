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


Route::middleware([ 'apikey' ])->group(function () {

    Route::get("bans/index","APIController@index");
    Route::get("bans/find","APIController@find");
    Route::post("bans/create","APIController@store");
    Route::post("bans/destroy","APIController@destroy");

});