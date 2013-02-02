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
	
	function add($post,$product_id)
	{
		$product_cost = $post['cost'];
		$product_url = $post['externalLink'];
		$data = mysql_query("INSERT INTO ".($this->table)." (`product_id`,`product_cost`,`product_url`,`created_at`) VALUES ('$product_id','$product_cost','$product_url',now()); ",$this->connection);
		
	}
}
?>