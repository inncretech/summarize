<?php
class product_image
{
	var $connection;
	var $table = "`product_image`";
	/* Class constructor */
	function product_image($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($image_id,$product_id)
	{
		$data = mysql_query("INSERT INTO ".($this->table)." (`image_id`,`product_id`,`created_at`) VALUES ('$image_id','$product_id',now()); ",$this->connection);
		return $this->getLastId();
	}
	
	function get($product_id)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `product_id`='$product_id'",$this->connection);
		$info = mysql_fetch_array($data);
		return $info['image_id'];
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>