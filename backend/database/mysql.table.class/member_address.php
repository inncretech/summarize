<?php
class member_address
{
	var $connection;
	var $table = "`member_address`";
	/* Class constructor */
	function member_address($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>