<?php
class facebook_friend
{
	var $connection;
	var $table = "`facebook_friend`";
	/* Class constructor */
	function facebook_friend($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($array,$member_id)
	{
		
		foreach($array['data'] as $friend){
			$data = mysql_query("SELECT * FROM ".$this->table." WHERE `member_id`= '".$member_id."' AND `friend_id`='".$friend['id']."'",$this->connection);
			
			if (mysql_num_rows($data)==0){
			$query = "INSERT INTO ".$this->table." (`member_id`,`friend_id`,`friend_name`) VALUES ('".$member_id."','".$friend['id']."','".$friend['name']."')";
			
			mysql_query($query,$this->connection);
			}
			
		}
		 
	}
	
	function get($member_id,$query)
	{
		$value = Array();

		$data = mysql_query("SELECT * FROM ".$this->table." WHERE `member_id`='".$member_id."' AND `friend_name` LIKE '%".$query."%' LIMIT 0,3",$this->connection);
		while ($info=mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
}
?>