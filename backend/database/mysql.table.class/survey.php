<?php
class survey
{
	var $connection;
	var $table = "`survey`";
	/* Class constructor */
	function survey($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	function get($survey_id){
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `survey_id`= $survey_id",$this->connection);
		return mysql_fetch_array($data);
	}
	
	function add($title,$created_by){
		$data = mysql_query("INSERT INTO ".($this->table)." (`title`,`created_by`,`created_at`) VALUES ('".$title."','".$created_by."',now())",$this->connection);
		return $this->getLastId();
	}
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(survey_id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>