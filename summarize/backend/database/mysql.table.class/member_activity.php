<?php
class member_activity
{
	var $connection;
	var $table = "`member_activity`";
	/* Class constructor */
	function member_activity($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>