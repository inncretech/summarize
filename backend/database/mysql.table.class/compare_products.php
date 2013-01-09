<?php
class compare_products
{
	var $connection;
	var $table = "`compare_products`";
	/* Class constructor */
	function compare_products($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>