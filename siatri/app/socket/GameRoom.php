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

		$room = $topic->getId();

		if(!array_key_exists($room, $this->games)){
			$this->games[$room] = array(); 
			$connection->cache->isHost = true;
		}

		$this->games[$room][$user->wampSession] = $user;

		$alreadyConnected = array();
		foreach ($this->games[$room] as $subscriber){
             if($subscriber->wampSession != $user->wampSession)
                	$alreadyConnected[$subscriber->wampSession] = $subscriber->username;
        }

        $msg = $this->msg("status", null, array("users" => $alreadyConnected));
		$this->broadcast($topic, $msg, $exclude = array(), $eligible = array($user->wampSession));


		$username = $user->username;
		echo "user $username subscribed; announcing...";
		$this->broadcast($topic, $this->msg("connect", $username));
		
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

	}

}