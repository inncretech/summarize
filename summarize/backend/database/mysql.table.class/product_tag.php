<?php
class product_tag
{
	var $connection;
	var $table = "`product_tag`";
	/* Class constructor */
	function product_tag($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
}
?>