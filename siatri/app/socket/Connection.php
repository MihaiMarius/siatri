<?php
use \Sidney\Latchet\BaseConnection;

class Connection extends BaseConnection {

	public function open($connection)
	{
		//in case of a mysql timeout, reconnect
        //to the database
        $app = app();
        $app['db']->reconnect();


		echo "\nuser connected\n";
	}

	public function close($connection)
	{

	}

	public function error($connection, $exception)
	{
		//close the connection
		$connection->close();

		throw new Exception($exception);
	}

}
