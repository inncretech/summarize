<?php
class member_feedback
{
	var $connection;
	var $table = "`member_feedback`";
	/* Class constructor */
	function member_feedback($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function check($feedback_id,$member_id)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `feedback_id`='$feedback_id' AND `member_id`='$member_id' ",$this->connection);
		return (mysql_num_rows($data)>0);
	}
	
	function add($feedback_id,$member_id)
	{
		$data = mysql_query("INSERT INTO ".($this->table)." (`feedback_id`,`member_id`,`created_at`) VALUES ('$feedback_id','$member_id',now()); ",$this->connection);
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>