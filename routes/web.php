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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::group(['middleware' => 'auth'],function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile/{slug}','ProfileController@index')->name('profile');
    Route::get('/changeavatar',function(){
        return view('profile.pic');
    });
    Route::get('/findfriends','ProfileController@findFriends')->name('friends');
    Route::post('/uploadavatar','ProfileController@uploadAvatar')->name('uploadavatar');
    Route::get('/editprofile','ProfileController@edit')->name('editprofile');
    Route::post('/updateprofile','ProfileController@update')->name('updateprofile');
    Route::get('/addfriend/{id}','ProfileController@sendRequest');
    Route::get('/requests','ProfileController@requests');
    Route::get('/accept/{name}/{id}','ProfileController@accept');
    Route::get('/removerequest/{id}','ProfileController@removeRequest');
    Route::get('/friends','ProfileController@friends');
});
