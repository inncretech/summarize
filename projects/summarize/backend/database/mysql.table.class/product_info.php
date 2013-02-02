<?php
class product_info
{
	var $connection;
	var $table = "`product_info`";
	/* Class constructor */
	function product_info($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>