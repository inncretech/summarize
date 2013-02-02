<?php
class notifications
{
	var $connection;
	var $table = "`notifications`";
	/* Class constructor */
	function notifications($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($member_id,$created_by,$type,$comment,$product_id,$product_title)
	{
			mysql_query("INSERT INTO ".($this->table)." (`member_id`,`created_by`,`type`,`comment`,`created_at`,`product_id`,`product_title`) VALUES ('$member_id','$created_by','$type','$comment',now(),'$product_id','$product_title') ",$this->connection);
		
	}
	
	function get($member_id,$limit)
	{
		$data = mysql_query("select * FROM".($this->table)." WHERE `member_id`='$member_id' AND `status`=0 ORDER BY `created_at` DESC LIMIT 0,".$limit,$this->connection);
		$info = Array();
		
		while ($value = mysql_fetch_array($data)){
			array_push($info,$value);
		}
		
		return $info;
	}
	
	function hide($id)
	{
		$data = mysql_query("UPDATE ".($this->table)." SET `status`=1 WHERE `id`='$id'",$this->connection);
		
	}
	
	function getCount($member_id)
	{
		$data = mysql_query("select count(*) FROM ".($this->table)." WHERE `member_id`='$member_id' AND `status`=0",$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
	
}
?>