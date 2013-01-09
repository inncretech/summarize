<?php
class point
{
	var $connection;
	var $table = "`point`";
	/* Class constructor */
	function point($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>