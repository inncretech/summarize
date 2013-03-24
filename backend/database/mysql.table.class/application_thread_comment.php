<?php
class application_thread_comment
{
	var $connection;
	var $table = "`application_thread_comment`";
	/* Class constructor */
	function application_thread_comment($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($data)
	{
		
		mysql_query("INSERT INTO ".($this->table)." (`thread_id`,`comment`,`created_by`,`created_at`) VALUES ('".$data['thread_id']."','".$data['comment']."','".$data['created_by']."',now())",$this->connection);

		
	}
	
	function get($data)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `thread_id` = '".$data['thread_id']."' ORDER BY `created_at` DESC",$this->connection);
		
		$value = Array();
		
		while ($info = mysql_fetch_array($data)) {
			array_push($value,$info);
		}
		
		return $value;
	}
}
?>