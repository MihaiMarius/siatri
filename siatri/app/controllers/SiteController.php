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
		$user = SessionManager::getAuthTwitterUser();

		if(!is_null($user)) {
			$game = new Game();

			$game->active = true;
			$game->save();

			$game->users()->attach($user->id, array('isHost' => true, 'score' => 0));
			
			 $selectedUserIds = Input::get('selectedUserIds');
			foreach ($selectedUserIds as $userId) {
				$addedUser = User::where('oauth_uid', '=', $userId)->first();

				if(is_null($addedUser)){
					$addedUser = new User;
					$addedUser->oauth_uid = $userId;
					$addedUser->save();
				}

				$game->users()->attach($addedUser->id, array('isHost' => false, 'score' => 0));
			}
			
			$successfullySentInvitation = $user->tweetInvitation($selectedUserIds);
			return Response::json(array("success" => $successfullySentInvitation));
		}
		return Response::json(array("success" => false, "redirectHome" => true));
	}


	public function testq(){
		$question = QuestionsManger::getNextQuestion();
		$anwears = QuestionsManger::getQuestionAnswears($question);

		//var_dump($question);
		var_dump($anwears);
		die();
	}
}