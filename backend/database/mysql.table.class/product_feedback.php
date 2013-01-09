<?php
class product_feedback
{
	var $connection;
	var $table = "`product_feedback`";
	/* Class constructor */
	function product_feedback($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>