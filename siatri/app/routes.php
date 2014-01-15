<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Latchet::connection('Connection');
Latchet::topic('room/{hostID}', 'GameRoom');

Route::get('/','SiteController@home');

Route::get('/login', 'TwitterController@index');
Route::get('/twitter_login', 'TwitterController@login');
Route::get('/twitter_auth', 'TwitterController@auth');
Route::get('/gamelobby', 'TwitterController@gamelobbyInit');

Route::post('/sendInvitation', 'TwitterController@sendInvitation');

//Test Routes
Route::get('/allusers', function(){

	$users = User::all();

	foreach ($users as $user ) {
		var_dump($user->oauth_uid);
		var_dump($user->username);
	}
});
