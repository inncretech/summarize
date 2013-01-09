<?php
class member_session
{
	var $connection;
	var $table = "`member_session`";
	/* Class constructor */
	function member_session($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>