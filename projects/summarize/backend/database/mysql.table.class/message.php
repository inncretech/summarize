<?php
class message
{
	var $connection;
	var $table = "`message`";
	/* Class constructor */
	function message($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($data)
	{
		mysql_query("INSERT INTO ".($this->table)." (`from_member_id`,`subject`,`body`,`to_member_id`,`created_at`) VALUES ('".$data['from_member_id']."','".$data['subject']."','".$data['body']."','".$data['to_member_id']."',now())",$this->connection);

	}
	
	function getReceived($member_id)
	{
		$value = Array();
		
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `to_member_id`= '$member_id'",$this->connection);
		while($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	function getSent($member_id)
	{
		$value = Array();
		
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `from_member_id`= '$member_id'",$this->connection);
		while($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
}
?>