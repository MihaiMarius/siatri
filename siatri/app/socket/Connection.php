<?php
use \Sidney\Latchet\BaseConnection;

class Connection extends BaseConnection {

	public function open($connection)
	{
		echo "connection established";
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
