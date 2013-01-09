<?php
class product
{
	var $connection;
	var $table = "`product`";
	/* Class constructor */
	function product($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>