<?php
class application_id
{
	var $connection;
	var $table = "`application_id`";
	/* Class constructor */
	function application_id($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($created_by,$application_request_id,$site_name)
	{
		$data = mysql_query("INSERT INTO ".($this->table)." (`application_request_id`,`site_name`,`created_by`,`created_at`) VALUES ('$application_request_id','$site_name','$created_by',now())" ,$this->connection);
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `application_request_id` = '$application_request_id'" ,$this->connection);
		$info = mysql_fetch_array($data);

		return $info;
	}
	
	function getByMember($created_by)
	{
		$data 	= mysql_query("SELECT * FROM ".($this->table)." WHERE `created_by` = '$created_by'" ,$this->connection);
		$value 	= Array();
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}

		return $value;
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(application_id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>