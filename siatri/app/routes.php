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

Route::get('/resetSession','SiteController@home');

Route::get('/', 'TwitterController@index');
Route::get('/twitter_login', 'TwitterController@login');
Route::get('/twitter_auth', 'TwitterController@auth');
Route::post('/sendInvitation', 'TwitterController@sendInvitation');

Route::get('/top', 'SiteController@topPlayers');
Route::get('/rules', 'SiteController@rules');
Route::get('/gamecreation', 'SiteController@gamecreation');



//Test Routes
// Route::get('/allusers', function(){

// 	$users = User::all();

// 	foreach ($users as $user ) {
// 		var_dump($user->oauth_uid);
// 		var_dump($user->username);
// 	}
// });
