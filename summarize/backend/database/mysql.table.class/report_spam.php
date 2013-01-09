<?php
class report_spam
{
	var $connection;
	var $table = "`report_spam`";
	/* Class constructor */
	function report_spam($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>