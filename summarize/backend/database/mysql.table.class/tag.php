<?php
class tag
{
	var $connection;
	var $table = "`tag`";
	/* Class constructor */
	function tag($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>