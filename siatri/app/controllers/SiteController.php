<?php

class SiteController extends BaseController {
	public function home()
	{
		if (SessionManager::isAnyUserLoggedin())
			return Redirect::to('/gamecreation');
		else
			return View::make('website.login');
	}

	public function topPlayers(){
		return View::make('website.top');
	}

	public function rules(){
		return View::make('website.rules');
	}

	public function gamecreation(){
		$user = SessionManager::getAuthTwitterUser();
		if(!is_null($user))
		{
			$data = array('username'=> $user->username);
			return View::make('website.creation', $data);
		}else{
			return Redirect::to('/');
		}

	}

	public function getGameHistory(){
		return Response::json(array("success" => true));

	}

	public function createGame(){
		
//create game
// and pivot for host
		// $game = new Game();
		// $gave->save();
		// $user = SessionManager::getAuthTwitterUser();

		// $user->games();
		// $user->save();

		 
		$user = SessionManager::getAuthTwitterUser();
		if($user) {
			$selectedUserIds = Input::get('selectedUserIds');
			$successfullySentInvitation = $user->tweetInvitation($selectedUserIds);
			return Response::json(array("success" => $successfullySentInvitation));
		}
		return Response::json(array("success" => false, "msg" => "no user"));
	}


}