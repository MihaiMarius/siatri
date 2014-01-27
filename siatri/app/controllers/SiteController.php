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
		$user = SessionManager::getAuthTwitterUser();

		if(!$user) Response::json(
			array("success" => false)
			);
			$games_models = $user->games;
		$games = array();

		foreach ($games_models as $game) {
			$stats = array( 'score' => $game->pivot->score );
			if ($game->pivot->isHost) $stats['host'] = $user->username;
			else $stats['host'] = $game->host();
			$games[] = $stats;
		}

		return Response::json(
			array(
				"success" => true,
				"games" => $games
				)
			);
	}

	public function createGame(){
		$game = new Game();
		$user = SessionManager::getAuthTwitterUser();
		

		if(!is_null($user)) {
			$selectedUserIds = Input::get('selectedUserIds');
			$successfullySentInvitation = $user->tweetInvitation($selectedUserIds);
			return Response::json(array("success" => $successfullySentInvitation));
		}
		return Response::json(array("success" => false, "msg" => "no user"));
	}


	public function testq(){
		$question = QuestionsManger::getNextQuestion();
		$anwears = QuestionsManger::getQuestionAnswears($question);

		//var_dump($question);
		var_dump($anwears);
		die();
	}
}