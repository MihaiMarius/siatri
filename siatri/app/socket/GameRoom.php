<?php
use \Sidney\Latchet\BaseTopic;

class GameRoom extends BaseTopic {

	public function subscribe($connection, $topic)
	{

	}

	public function publish($connection, $topic, $message, array $exclude, array $eligible)
	{
		
		// broadcast
		$this->broadcast($topic, array('from' => 'broadcast: '.$connection->WAMP->sessionId, 'msg' => $message));
		
		// push
		Latchet::publish($topic->getId(), array('from' => 'push: '.$connection->WAMP->sessionId, 'msg' => $message));
	}

	public function call($connection, $id, $topic, array $params)
	{
		$this->broadcast($topic, array('from' => 'broadcast from push for: '.$connection->WAMP->sessionId, 'msg' => $message));

	}

	public function unsubscribe($connection, $topic)
	{

	}

}