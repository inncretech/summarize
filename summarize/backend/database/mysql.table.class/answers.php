<?php
class answers
{
	var $connection;
	var $table = "`answers`";
	/* Class constructor */
	function answers($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>