<?php
class school
{
	var $connection;
	var $table = "`school`";
	/* Class constructor */
	function school($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>