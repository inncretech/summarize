<?php
class message_details
{
	var $connection;
	var $table = "`message_details`";
	/* Class constructor */
	function message_details($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>