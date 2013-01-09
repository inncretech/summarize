<?php
class questions
{
	var $connection;
	var $table = "`questions`";
	/* Class constructor */
	function questions($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>