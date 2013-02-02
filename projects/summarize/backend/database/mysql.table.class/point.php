<?php
class point
{
	var $connection;
	var $table = "`point`";
	/* Class constructor */
	function point($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($member_id,$point_reason,$product_id,$point_value)
	{
		mysql_query("INSERT INTO ".($this->table)." (`member_id`,`point_reason`,`product_id`,`created_at`,`point_value`) VALUES ('$member_id','$point_reason','$product_id',now(),'$point_value')",$this->connection);
		
	}
	
	function get($member_id)
	{
		$info = $this->getTotal($member_id);
		
		return $info;
	}
	
	
	
	function getByReason($member_id)
	{
		$value 	= Array();
		$data 	= mysql_query("SELECT SUM(point_value) as value,point_reason  FROM ".($this->table)." WHERE `member_id` = '$member_id' GROUP BY `point_reason`",$this->connection);
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	function getTotal($member_id)
	{
		$data = mysql_query("SELECT SUM(point_value) as value  FROM ".($this->table)." WHERE `member_id` = '$member_id'",$this->connection);
		$info = mysql_fetch_array($data);
		
		return $info['value'];
	}
}
?>