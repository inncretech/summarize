<?php
class member_activity
{
	var $connection;
	var $table = "`member_activity`";
	/* Class constructor */
	function member_activity($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($member_id,$type,$comment,$product_id,$product_public_id,$product_title)
	{
		
		mysql_query("INSERT INTO ".($this->table)."(`member_id`,`type`,`comment`,`product_id`,`product_public_id`,`product_title`,`created_at`) VALUES ('$member_id','$type','$comment','$product_id','$product_public_id','$product_title',now())",$this->connection);
	}
	
	function get($member_id,$limit)
	{
		$data = mysql_query("select * FROM".($this->table)." WHERE `member_id`='$member_id' ORDER BY `created_at` DESC LIMIT 0,".$limit,$this->connection);
		$info = Array();
		
		while ($value = mysql_fetch_array($data)){
			array_push($info,$value);
		}
		
		return $info;
	}
}
?>