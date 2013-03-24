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
	
	function check($member_id,$product_id)
	{
		$data 	= mysql_query("SELECT * FROM ".($this->table)." WHERE `member_id`='$member_id' AND `product_id` = '$product_id' ",$this->connection);
		return ((mysql_num_rows($data))>0);
	}
	
	
	function getFollowers($product_id)
	{
		$value = Array();
		$data 	= mysql_query("SELECT * FROM ".($this->table)." WHERE `product_id` = '$product_id' ",$this->connection);
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
	
		return $value;
	}
	
	function getRandomFollowedBy($member_id,$limit)
	{
		$value = Array();
		$data 	= mysql_query("SELECT * FROM ".($this->table)." WHERE `member_id` = '$member_id' LIMIT ".$limit,$this->connection);
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		
		return $value;
	}
	
	function toggle($member_id,$product_id)
	{
		if ($this->check($member_id,$product_id)){
			mysql_query("DELETE FROM ".($this->table)." WHERE `member_id`='$member_id' AND `product_id` = '$product_id' ",$this->connection);
			return true;
		}else{
			mysql_query("INSERT INTO ".($this->table)." (`member_id`,`product_id`,`created_at`) VALUES ('$member_id','$product_id',now()) ",$this->connection);
			return false;
		}
	}
}
?>