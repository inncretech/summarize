<?php
class member_employer
{
	var $connection;
	var $table = "`member_employer`";
	/* Class constructor */
	function member_employer($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>