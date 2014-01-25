<?php


class TwitterController extends BaseController {


	public function index()
	{
		if (SessionManager::isAnyUserLoggedin()) {
			return Redirect::to('/gamecreation'); 
		}else{
			return View::make('website.login');
		}		
	}

	public function login(){
		// check if seesion isn't empty
		$tokens = Twitter::oAuthRequestToken();
		Twitter::oAuthAuthenticate(array_get($tokens, 'oauth_token'));
		exit;
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
			
			$hasAuthFailed = !property_exists($accessToken, 'user_id');
			if($hasAuthFailed){
				return Redirect::to('/');
			}else{	
				$this->saveAuthentificatedUserDetails($accessToken);
				SessionManager::setTwitterUserIdSession($accessToken->user_id);
				return Redirect::to('/gamecreation');
			}
		}

	/*
		Save the user in the database if the user is not already in the database.
		@params object Object received from twitter after authentification 
	*/
		private function saveAuthentificatedUserDetails($accessToken){
			$userExists = count(User::where('oauth_uid', '=', $accessToken->user_id)->get()) > 0;

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