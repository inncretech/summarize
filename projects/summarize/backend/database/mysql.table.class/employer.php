<?php
class employer
{
	var $connection;
	var $table = "`employer`";
	/* Class constructor */
	function employer($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>