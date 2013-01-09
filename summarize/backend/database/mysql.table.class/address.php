<?php
class address
{
	var $connection;
	var $table = "`address`";
	/* Class constructor */
	function address($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>