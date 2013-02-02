<?php
class member_answer
{
	var $connection;
	var $table = "`member_answer`";
	/* Class constructor */
	function member_answer($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($data)
	{
		mysql_query("INSERT INTO ".($this->table)." (`member_id`,`answer_id`,`created_at`) VALUES ('".$data['member_id']."','".$data['answer_id']."',now())",$this->connection);
	}
	
	function check($data)
	{
		$data 	= mysql_query("SELECT * FROM ".($this->table)." WHERE `member_id` = '".$data['member_id']."' AND `answer_id` = '".$data['answer_id']."'",$this->connection);
		return (mysql_num_rows($data)==0);
	}
	
}
?>