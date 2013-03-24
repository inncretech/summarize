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
	
	function getMultiple($tag_id_array)
	{
		$product_info = Array();
		$query = "SELECT DISTINCT(product_id) FROM ".($this->table)." WHERE ";
		foreach ($tag_id_array as $id){
			$query .= " `tag_id` = '$id' OR ";
		}
		$query .= " 1=2 ";
		$data = mysql_query($query,$this->connection);
		
		while ($info = mysql_fetch_array($data)){
			array_push($product_info,$info[0]);
		}
		
		return $product_info;
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
	
	function getByMultipleTags($tag_data)
	{
		$product_id = Array();
		$query = "SELECT * FROM ".($this->table)." WHERE ";
		foreach ($tag_data as $id){
			$query .=" `tag_id` = '".$id['id']."' AND ";
			
		}
		$query = substr_replace($query ,"",-4);
		$data = mysql_query($query,$this->connection);
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