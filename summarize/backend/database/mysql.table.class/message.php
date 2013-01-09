<?php
class message
{
	var $connection;
	var $table = "`message`";
	/* Class constructor */
	function message($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>