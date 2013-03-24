<?php
class survey_answer
{
	var $connection;
	var $table = "`survey_answer`";
	/* Class constructor */
	function survey_answer($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function get($question_id){
		$value = Array();
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `question_id`= $question_id",$this->connection);
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	function add($question_id,$survey_id,$text,$created_by){
		$data = mysql_query("INSERT INTO ".($this->table)." (`question_id`,`survey_id`,`text`,`created_by`,`created_at`) VALUES ('".$question_id."','".$survey_id."','".$text."','".$created_by."',now())",$this->connection);
		return $this->getLastId();
	}
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(answer_id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>