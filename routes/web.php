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

Route::get('/forgetpassword',function(){
    return view('profile.forgetpassword');
});
Route::get('/gettoken/{token}',function($token){
    if(isset($token) && $token != '') {
        $data = DB::table('password_resets')->where('token',$token)->get();
        if(count($data) != 0) {
            return view('profile.setpassword')->with('data',$data);
        }
        else {
            echo "token is wrong";
        }
    }
    else {
        echo "token is wrong";
    }
});
Route::get('setpass','ProfileController@setPass');
Route::post('/settoken','ProfileController@setToken')->name('settoken');

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
    Route::get('/notifications/{id}','ProfileController@notifications');
    Route::get('/unfriend/{id}','ProfileController@unfriend');
    Route::post('/post/store',['as'=>'/post/store','uses'=>'PostController@store']);
    Route::get('/post/lists','PostController@index');
    Route::get('/message/lists','MessageController@index');
    Route::get('/message', function () {
        return view('message.index');
    });
    Route::post('/message/store',['as'=>'/message/store','uses'=>'MessageController@store']);
    Route::get('/message/{id}','MessageController@getMessage');

    Route::get('/newmessage','MessageController@newMessage')->name('newnessage');
    Route::post('/message/newmessage',['as'=>'//message/newmessage','uses'=>'MessageController@sendNewMessage']);
    //Route::resource('post','PostController');
});
Route::get('/posts','PostController@index');
Route::get('/messages','MessageController@index');
