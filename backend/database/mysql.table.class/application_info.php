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
	
	function checkApp($app_id,$domain)
	{
		$data = mysql_query("SELECT * FROM ".$this->table." WHERE `application_id`='".$app_id."' AND `site_url`='".$domain."'" ,$this->connection);
		
		return (mysql_num_rows($data)>0);
	}
}
?>