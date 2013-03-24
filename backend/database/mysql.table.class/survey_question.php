<?php
class survey_question
{
	var $connection;
	var $table = "`survey_question`";
	/* Class constructor */
	function survey_question($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function get($survey_id){
		$value = Array();
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `survey_id`= $survey_id",$this->connection);
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	function add($survey_id,$text,$type,$created_by){
		$data = mysql_query("INSERT INTO ".($this->table)." (`survey_id`,`text`,`type`,`created_by`,`created_at`) VALUES ('".$survey_id."','".$text."','".$type."','".$created_by."',now())",$this->connection);
		return $this->getLastId();
	}
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(question_id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>