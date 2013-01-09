<?php
class notifications
{
	var $connection;
	var $table = "`notifications`";
	/* Class constructor */
	function notifications($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>