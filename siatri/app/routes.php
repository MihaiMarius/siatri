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
use Illuminate\Support\MessageBag;

Route::filter('check', function($route, $request)
{
    if(!SessionManager::isAnyUserLoggedin()){ // || the user is not allowed in this game
        Session::put('redirect', $request->path());
        return Redirect::to('/login')->withErrors(
            new MessageBag(array(
                'info' => 'You must be logged into the Siatri appliation via Twitter first!'
            )
        ));
    }
});

Route::group(array('prefix' => 'game', 'before' => 'check'), function()
{
    Route::post('syncWampSession','GameController@syncWampSession');
    Route::get('lobby/{host}','GameController@lobby');
});

Latchet::connection('Connection');
Latchet::topic('/game/{host}', 'GameRoom');


Route::get('/','SiteController@home');
Route::get('/logout', 'TwitterController@logout');


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
