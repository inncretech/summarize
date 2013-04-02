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
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `survey_id`= $survey_id AND `active`=0",$this->connection);
		return mysql_fetch_array($data);
	}
	
	function getByMember($created_by){
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `created_by`= $created_by AND `active`=0",$this->connection);
		$value = Array();
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	function add($title,$created_by){
		$data = mysql_query("INSERT INTO ".($this->table)." (`title`,`created_by`,`created_at`) VALUES ('".$title."','".$created_by."',now())",$this->connection);
		return $this->getLastId();
	}
	
	function remove($survey_id)
	{	
		$data = mysql_query("UPDATE ".($this->table)." SET `active` = 1 WHERE `survey_id`=0",$this->connection);
		
	}
	
	function getWeeklyCount()
	{	
		$data = mysql_query("SELECT COUNT(survey_id) FROM ".($this->table)." WHERE created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
AND created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY",$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
	function countActive()
	{	
		$data = mysql_query("SELECT COUNT(survey_id) FROM ".($this->table)." WHERE `active`=0",$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(survey_id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>