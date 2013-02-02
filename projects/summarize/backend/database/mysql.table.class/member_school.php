<?php
class member_school
{
	var $connection;
	var $table = "`member_school`";
	/* Class constructor */
	function member_school($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>