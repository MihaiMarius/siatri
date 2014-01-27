<?php
use \Sidney\Latchet\BaseConnection;

class Connection extends BaseConnection {

	public function open($connection)
	{
		//in case of a mysql timeout, reconnect
        //to the database
        $app = app();
        $app['db']->reconnect();
        $session = $connection->WAMP->sessionId;

		echo "\nvalidating $session...\n";
	}

	public function close($connection)
	{
        if(isset($connection->cache)){
            $user = $connection->cache->user;
            if(isset($connection->cache->handler)){
                $connection->cache->handler->unsubscribe($connection, $connection->cache->room);
                 echo "$user->username disconnected\n";
            }
            else  echo "connection closed. User was subscribed \n";
        }
        else echo "connection closed. User was not even connected \n";

	}

	public function error($connection, $exception)
	{
        echo "error happened";
		//close the connection
		$connection->close();

		throw new Exception($exception);
	}

}
