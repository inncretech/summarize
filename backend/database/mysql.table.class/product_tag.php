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
	
	function add($tag_id,$product_id)
	{
		$data = mysql_query("INSERT INTO ".($this->table)." (`tag_id`,`product_id`,`created_at`) VALUES ('$tag_id','$product_id',now()); ",$this->connection);
		return $this->getLastId();
	}
	
	function get($product_id)
	{
		$tag_id = Array();
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `product_id`='$product_id'",$this->connection);
		While ($info = mysql_fetch_array($data)){
			array_push($tag_id,$info["tag_id"]);
		}
		return $tag_id;
	}
	
	function getByTag($tag_id)
	{
		$product_id = Array();
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `tag_id`='$tag_id'",$this->connection);
		While ($info = mysql_fetch_array($data)){
			array_push($product_id,$info["product_id"]);
		}
		return $product_id;
	}
	
	function remove($tag_id,$product_id)
	{
		mysql_query("DELETE FROM ".($this->table)." WHERE `tag_id` = '$tag_id' AND `product_id`= '$product_id'",$this->connection);
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>