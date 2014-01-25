<?php
use \Sidney\Latchet\BaseTopic;

class GameRoom extends BaseTopic {

	private $users;

	public function subscribe($connection, $topic)
	{
		// var_dump($connection->WAMP);
		// var_dump($topic);
		$user = User::where('wampSession','=', $connection->WAMP->sessionId)->first();
		$connection->cache = new StdClass;
		$connection->cache->user = $user;
		$username = $user->username;
		// add user to room
		// inspire from whatup

		$this->broadcast($topic, array('from' => $connection->cache->user->username, 
			'm' => array(
				'mtype' => 'connect'
			)
		));

		echo "user $username subscribed";
	}

	public function publish($connection, $topic, $message, array $exclude, array $eligible)
	{
		
		// broadcast
		$this->broadcast($topic, array('from' => $connection->cache->user->username, 'm' => $message));
		
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