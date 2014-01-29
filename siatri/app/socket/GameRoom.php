<?php
use \Sidney\Latchet\BaseTopic;

class GameRoom extends BaseTopic {

	protected $games = array();

	private function msg( $type, $who = null, $msg = null){
		return array(
			"type" => $type,
			"from" => $who,
			"msg" => $msg
		);
	}

	public function subscribe($connection, $topic)
	{
		// var_dump($connection->WAMP);
		// var_dump($topic);
		$user = User::where('wampSession','=', $connection->WAMP->sessionId)->first();
		if(!$user) {
			$connection->close();
		}

		$connection->cache = new StdClass;
		$connection->cache->user = $user;
		$connection->cache->isHost = false;
		$connection->cache->handler = $this;
		$connection->cache->room = $topic;

		$roomID = $topic->getId();

		if(!array_key_exists($roomID, $this->games)){
			$this->games[$roomID] = array(); 
			$this->games[$roomID]["started"] = false;
			$this->games[$roomID]['users'] = array();
			$connection->cache->isHost = true;
		}

		$this->games[$roomID]['users'][$user->wampSession] = $user;

		$alreadyConnected = array();
		foreach ($this->games[$roomID]['users'] as $subscriber){
             if($subscriber->wampSession != $user->wampSession)
                	$alreadyConnected[$subscriber->wampSession] = $subscriber->username;
        }

        $msg = $this->msg("status", null, array("users" => $alreadyConnected));
		$this->broadcast($topic, $msg, $exclude = array(), $eligible = array($user->wampSession));


		echo "user $user->username subscribed; announcing...\n";
		$this->broadcast($topic, $this->msg("connect", $user->username));
		
	}

	private function setQuestions($roomID, $handler){
		$q = QuestionManager::getNextQuestion();
		$ans = QuestionManager::getQuestionAnswears(q);
		$this->games[$roomID]["currentQuestion"] = $q->q;
		$this->games[$roomID]["currentAnswer"] = $ans;
	}
	public function publish($connection, $topic, $message, array $exclude, array $eligible)
	{
		// $mtype = $connection->cache->isHost ? "mine" : "general";
		// broadcast

		$roomID = $topic->getId();
		if($message == "/gameStart"){
			$this->games[$roomID]["started"] = true;
			$this->games[$roomID]["currentQuestion"] = "What is 2 + 2?";
			$this->games[$roomID]["currentAnswer"] = 4;
			$this->broadcast($topic, $this->msg("question", "system", $this->games[$roomID]["currentQuestion"]));
		}
		elseif($message == "/nextQuestion"){
			$this->games[$roomID]["currentQuestion"] = "What is 2 + 3?";
			$this->games[$roomID]["currentAnswer"] = 5;
			$this->broadcast($topic, $this->msg("question", "system", $this->games[$roomID]["currentQuestion"]));
		}
		else{
			$this->broadcast($topic, $this->msg("general", $connection->cache->user->username, $message));
			if($this->games[$roomID]["started"] && $message == $this->games[$roomID]["currentAnswer"])
				$this->broadcast($topic, $this->msg("answer", $connection->cache->user->username));
		}
		
		// push
		// Latchet::publish($topic->getId(), array('from' => 'push: '.$connection->WAMP->sessionId, 'msg' => $message));
	}

	public function call($connection, $id, $topic, array $params)
	{
		// $this->broadcast($topic, array('from' => 'broadcast from push for: '.$connection->WAMP->sessionId, 'msg' => $message));

	}

	public function unsubscribe($connection, $topic)
	{
		$user = $connection->cache->user;
		$roomID = $topic->getId();
		// var_dump(count($this->games[$roomID]));
		unset($this->games[$roomID]['users'][$user->wampSession]); //remove user from game
		// var_dump(count($this->games[$roomID]));

		$this->broadcast($topic, $this->msg("disconnect", $user->username));

		echo "$user->username unsubscribed from $roomID\n";
		if($connection->cache->isHost){
			echo "this is a host so the game ends!";
			unset($this->games[$roomID]);
			$game = $user->games()->where('active', '=', 1)->get()->first();
			if($game){
				$game->active = false;
				$game->save();
			}

			else echo "GAME IS NULL";
			echo "that  worked!";
		}
	}

}