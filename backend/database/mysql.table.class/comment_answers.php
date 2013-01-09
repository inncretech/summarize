<?php
class comment_answers
{
	var $connection;
	var $table = "`comment_answers`";
	/* Class constructor */
	function comment_answers($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>