<?php
class application_info
{
	var $connection;
	var $table = "`application_info`";
	/* Class constructor */
	function application_info($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($data)
	{
		mysql_query("INSERT INTO ".($this->table)." (`application_id`,`site_name`,`site_url`,`created_by`,`created_at`) VALUES ('".$data['application_id']."','".$data['site_name']."','".$data['site_url']."','".$data['created_by']."',now())" ,$this->connection);
		
	}
}
?>