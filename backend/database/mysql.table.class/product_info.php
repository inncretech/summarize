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
		$product_cost 	= $post['cost'];
		$product_url 	= $post['externalLink'];
		$external 		= $post['external'];
		$data = mysql_query("INSERT INTO ".($this->table)." (`product_id`,`product_cost`,`product_url`,`created_at`,`external`) VALUES ('$product_id','$product_cost','$product_url',now(),'$external'); ",$this->connection);
		
	}
	
	function getByProduct($product_id)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `product_id`='$product_id' ",$this->connection);
		$info = mysql_fetch_array($data);
		return $info;
	}
	
	function getByExternalLink($link)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `product_url`='$link' AND `product_url` IS NOT NULL AND `external`=1",$this->connection);
		if (mysql_num_rows($data)>0){
			$info = mysql_fetch_array($data);
			return $info['product_id'];
		}
		return false;
	}
}
?>