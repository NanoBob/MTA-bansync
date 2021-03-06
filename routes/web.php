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
Route::get('/contributors', 'StaticPageController@contributors')->name('contributors');
Route::get('/verification', 'StaticPageController@verification')->name('verification')->middleware('auth','server');

Route::post("/verification", "VerificationController@store")->name("verification.store")->middleware('auth','server');
Route::get("/verification/{id}", "VerificationController@view")->name("verification.view")->middleware('auth','userServer');
Route::post("/verification/{id}/approve", "VerificationController@approve")->name("verification.approve")->middleware('auth','userServer');
Route::post("/verification/{id}/decline", "VerificationController@decline")->name("verification.decline")->middleware('auth','userServer');

Route::group([ "middleware" => [ "auth" ] ],function(){
    Route::get('/appeal', 'PublicAppealController@index')->name('appeal.index');
    Route::get('/appeal/list', 'PublicAppealController@banList')->name('appeal.list');
    Route::get('/appeal/create/{appeal_code}/{id}', 'PublicAppealController@create')->name('appeal.create');
    Route::post('/appeal/create/{id}', 'PublicAppealController@store')->name('appeal.store');
    Route::get('/appeal/{id}','PublicAppealController@view')->name('appeal.view');
    Route::post('/appeal/edit/{id}','PublicAppealController@update')->name('appeal.update');
    Route::post('/appeal/{id}','PublicAppealController@reply')->name('appeal.reply');
});

Route::get("/signup","SignupController@index")->name("signup.index");
Route::post("/signup","SignupController@submit")->name("signup.submit");


Route::prefix('/manage')->middleware([ 'auth', 'userServer' ])->group(function () {
    Route::get("/",'ManagementController@index')->name("manage.dashboard");
    Route::resource("/bans","BanController", [ "as" => "manage"]);
    Route::resource("/appeals",'AppealController', [ "as" => "manage" ]);

    Route::get("/verifications",'VerificationController@index', [ "middleware" => "verifyVerified" ])->name("manage.verification.list");

    Route::group([ "middleware" => [ "server"] ],function(){
        Route::resource("/admins",'AdminController', [ "as" => "manage" ]);
        Route::get("/developers",'ManagementController@developers')->name("manage.developers");
        Route::resource("/settings","ServerSettingController", [ "as" => "manage"]);

    });
});