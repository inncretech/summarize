<?php
class survey_member_answer
{
	var $connection;
	var $table = "`survey_member_answer`";
	/* Class constructor */
	function survey_member_answer($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function countByQuestion($question_id){
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `question_id`= $question_id",$this->connection);
		return mysql_num_rows($data);
	}
	
	function getByQuestion($question_id){
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `question_id`= $question_id",$this->connection);
		$value = Array();
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		
		return $value;
	}
	
	function countByQuestionAndAnswer($question_id,$answer_id){
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `question_id`= $question_id AND `answer_id`= $answer_id",$this->connection);
		return mysql_num_rows($data);
	}
	
	function add($member_id,$email,$survey_id,$question_id,$answer_id,$text){
		$data = mysql_query("INSERT INTO ".($this->table)." (`member_id`,`email`,`survey_id`,`question_id`,`answer_id`,`text`,`created_at`) VALUES ('".$member_id."','".$email."','".$survey_id."','".$question_id."','".$answer_id."','".$text."',now())",$this->connection);
		
	}
}
?>