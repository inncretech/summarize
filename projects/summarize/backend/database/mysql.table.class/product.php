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
	
	function add($post)
	{
		$title = $post['title'];
		$description = $post['description'];
		$created_by = $post['created_by'];
		$data = mysql_query("INSERT INTO ".($this->table)." (`title`,`description`,`created_by`,`created_at`) VALUES ('$title','$description','$created_by',now()); ",$this->connection);
		return $this->getLastId();
	}
	
	function get($product_id)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `product_id` = '$product_id'",$this->connection);
		return mysql_fetch_array($data);
	}
	
	function getRandom($limit)
	{	
		$value = Array();
	
		$data = mysql_query("SELECT * FROM ".($this->table)." ORDER BY RAND() LIMIT ".$limit,$this->connection);
		while($info=mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	function getRandomCreatedBy($member_id,$limit)
	{	
		$value = Array();
	
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `created_by` = '$member_id' ORDER BY RAND() LIMIT ".$limit,$this->connection);
		while($info=mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}	
	
	function getSearchData($query)
	{
		$data = mysql_query("SELECT product_id,title FROM ".($this->table)." WHERE `title` LIKE '%".$query."%'",$this->connection);
		
		$values = Array();
		while ($info = mysql_fetch_array($data)){
			$aux = Array();
			$aux['product_id']	=$info['product_id'];
			$aux['title']		=$info['title'];
			array_push($values,$aux);
		}
		return $values;
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(product_id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>