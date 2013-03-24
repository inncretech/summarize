<?php
class survey_completed
{
	var $connection;
	var $table = "`survey_completed`";
	/* Class constructor */
	function survey_completed($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	function check($survey_id,$member_id)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `survey_id`= $survey_id AND `member_id`= $member_id",$this->connection);
		return mysql_num_rows($data)>0;
	}
	function add($survey_id,$member_id)
	{
		mysql_query("INSERT INTO ".($this->table)." (`survey_id`,`member_id`,`created_at`) VALUES ('".$survey_id."','".$member_id."',now())",$this->connection);
	}
}
?>