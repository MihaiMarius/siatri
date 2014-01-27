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
		if(!$user) $connection->close();

		$connection->cache = new StdClass;
		$connection->cache->user = $user;
		$connection->cache->isHost = false;
		$connection->cache->handler = $this;
		$connection->cache->room = $topic;

		$roomID = $topic->getId();

		if(!array_key_exists($roomID, $this->games)){
			$this->games[$roomID] = array(); 
			$connection->cache->isHost = true;
		}

		$this->games[$roomID][$user->wampSession] = $user;

		$alreadyConnected = array();
		foreach ($this->games[$roomID] as $subscriber){
             if($subscriber->wampSession != $user->wampSession)
                	$alreadyConnected[$subscriber->wampSession] = $subscriber->username;
        }

        $msg = $this->msg("status", null, array("users" => $alreadyConnected));
		$this->broadcast($topic, $msg, $exclude = array(), $eligible = array($user->wampSession));


		echo "user $user->username subscribed; announcing...\n";
		$this->broadcast($topic, $this->msg("connect", $user->username));
		
	}

	public function publish($connection, $topic, $message, array $exclude, array $eligible)
	{
		// $mtype = $connection->cache->isHost ? "mine" : "general";
		// broadcast
		$this->broadcast($topic, $this->msg("general", $connection->cache->user->username, $message));
		
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
		unset($this->games[$roomID][$user->wampSession]); //remove user from game
		// var_dump(count($this->games[$roomID]));
		echo "$user->username unsubscribed from $roomID\n";
		if($connection->cache->isHost){
			echo "this is a host so the game ends!";
			unset($this->games[$roomID]);
			$game = $user->games;//->where('is_active', '=',1);//->first();
			if($game->first())
				var_dump($game->first()->active);
			else echo "GAME IS NULL";
			echo "that  worked!";
		}
	}

}