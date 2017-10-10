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

Auth::routes();

Route::get('/', 'StaticPageController@index')->name('home');
Route::get('/banned', 'StaticPageController@banned')->name('banned');
Route::get('/developers', 'StaticPageController@developers')->name('developers');

Route::get('/appeal', 'AppealController@index')->name('appeal.index');
Route::post('/appeal', 'AppealController@create')->name('appeal.create');
Route::get('/appeal/{id}','AppealController@view')->name('appeal.view');
Route::post('/appeal/{id}','AppealController@reply')->name('appeal.reply');
Route::post('/appeal{id}/accept','AppealController@accept')->name('appeal.accept');
Route::post('/appeal{id}/deny','AppealController@deny')->name('appeal.deny');

Route::get("/signup","SignupController@index")->name("signup.index");
Route::post("/signup","SignupController@submit")->name("signup.submit");


Route::prefix('/manage')->middleware([ 'auth' ])->group(function () {
    Route::get("/",'ManagementController@index')->name("manage.dashboard");
    Route::get("/appeals",'ManagementController@appeals')->name("manage.appeals");
    Route::get("/developers",'ManagementController@developers')->name("manage.developers");

    Route::resource("/settings","ServerSettingController", [ "as" => "manage"]);
    Route::resource("/bans","BanController", [ "as" => "manage"]);

});

Route::prefix('api')->middleware([ 'apikey' ])->group(function () {

    Route::resource("bans","APIController");

});