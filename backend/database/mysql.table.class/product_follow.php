<?php
class product_follow
{
	var $connection;
	var $table = "`product_follow`";
	/* Class constructor */
	function product_follow($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>