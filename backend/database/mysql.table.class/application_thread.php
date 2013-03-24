<?php
class application_thread
{
	var $connection;
	var $table = "`application_thread`";
	/* Class constructor */
	function application_thread($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function check($data)
	{
		$info = mysql_query("SELECT * FROM ".($this->table)." WHERE `thread_id` = '".$data['thread_id']."' AND `application_id` = '".$data['application_id']."'",$this->connection);
		if (mysql_num_rows($info)==0){

			mysql_query("INSERT INTO ".($this->table)." (`thread_id`,`application_id`,`created_at`) VALUES ('".$data['thread_id']."','".$data['application_id']."',now())",$this->connection);
			
		}
	}
	

}
?>