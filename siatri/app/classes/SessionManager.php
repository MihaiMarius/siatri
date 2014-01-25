<?php

class SessionManager{

	/*
		Set user_id on session
		$param object Object received from twitter after authentification
	*/
		public static function setTwitterUserIdSession($user_id){
			Session::put('oauth_uid', $user_id);
		}

	/*
		Get user_id from session or redirects to login
		$param object Object received from twitter after authentification
	*/
		public static function getTwitterUserIdSession(){
			if (Session::has('oauth_uid'))
			{
				$user_id = Session::get('oauth_uid');
				return $user_id;
			}
			return '';
		}

		public static function isAnyUserLoggedin()
		{
			$user_id = static::getTwitterUserIdSession();
			return $user_id != '';
		}

		public static function getAuthTwitterUser(){
			

			if(static::isAnyUserLoggedin())
			{
				$user_id = static::getTwitterUserIdSession();
				$user = User::where('oauth_uid', '=', $user_id)->first();

				// var_dump($user_id);
				// var_dump(User::all());
				// die();

				return $user;
			}
			return null;
		}
	}