<?php
class view_details
{
	var $connection;
	var $table = "`view_details`";
	/* Class constructor */
	function view_details($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>