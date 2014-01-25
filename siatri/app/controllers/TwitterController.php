<?php


class TwitterController extends BaseController {

	public function login(){
		if (SessionManager::isAnyUserLoggedin()) {

			if($goto = Session::get('redirect')){
				Session::forget('redirect');
				return Redirect::to($goto);
			}
			else return Redirect::to('/gamecreation'); 
		}else{
			$tokens = Twitter::oAuthRequestToken();
			Twitter::oAuthAuthenticate(array_get($tokens, 'oauth_token'));
			exit;
		}	

	}

    public function logout(){
        Session::clear();
        return Redirect::to('/');
    }

	/*
		Function called after twitter callback
	*/
	public function auth(){
		//tokens used to get accesstoken from twitter
		$token = Input::get('oauth_token');
		$verifier = Input::get('oauth_verifier');


	// Request access token
		$accessToken = (object)Twitter::oAuthAccessToken($token, $verifier);
		
		$hasAuthSucceded = property_exists($accessToken, 'user_id');
		if($hasAuthSucceded){
			$this->saveAuthentificatedUserDetails($accessToken);
			SessionManager::setTwitterUserIdSession($accessToken->user_id);
		}
		return Redirect::to('/login');
	}

	/*
		Save the user in the database if the user is not already in the database.
		@params object Object received from twitter after authentification 
	*/
	private function saveAuthentificatedUserDetails($accessToken){
		$userExists = count(User::where('oauth_uid', '=', $accessToken->user_id)->get()) > 0;
		Session::put('user',$accessToken->screen_name);
		if(!$userExists){
			$oauth_token = $accessToken->oauth_token;
			$oauth_token_secret = $accessToken->oauth_token_secret;
			$user_id = $accessToken->user_id;
			$screen_name = $accessToken->screen_name;

			$user = new User;
			$user->oauth_provider = '';
			$user->oauth_uid = $accessToken->user_id;
			$user->oauth_token = $accessToken->oauth_token;
			$user->oauth_secret = $accessToken->oauth_token_secret;
			$user->username = $accessToken->screen_name;

			$user->save();
		}		
	}

	public function sendInvitation(){
		$user = SessionManager::getAuthTwitterUser();
		$selectedUserIds = Input::get('selectedUserIds');
		$successfullySentInvitation = $user->tweetInvitation($selectedUserIds);
		return Response::json(array("success" => $successfullySentInvitation));
		
	}
}
