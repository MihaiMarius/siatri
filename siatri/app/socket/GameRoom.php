<?php
use \Sidney\Latchet\BaseTopic;

class GameRoom extends BaseTopic {

	protected $games = array();


	public function subscribe($connection, $topic)
	{
		// var_dump($connection->WAMP);
		// var_dump($topic);
		$user = User::where('wampSession','=', $connection->WAMP->sessionId)->first();
		$connection->cache = new StdClass;
		$connection->cache->user = $user;
		$username = $user->username;
		
		if(!array_key_exists($topic, $this->games))
			$this->games[$topic] = array();

		$this->games[$topic][$user->wampSession] = $user;

		$this->broadcast($topic, array('from' => $username, 
			'm' => array(
				'mtype' => 'connect'
			)
		));

// foreach ($this->rooms[$room_name] as $subscriber)
//                         {
//                                 if($subscriber->session_id != $user->session_id)
//                                 {
//                                         $msg = array(
//                                                 'action' => 'newUser',
//                                                 'user' => $subscriber->toJson()
//                                         );
//                                         $this->broadcast($topic, $msg, $exclude = array(), $eligible = array($user->session_id));
//                                 }
//                         }
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