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
	
	function add($member_id,$email,$survey_id,$question_id,$answer_id,$text){
		$data = mysql_query("INSERT INTO ".($this->table)." (`member_id`,`email`,`survey_id`,`question_id`,`answer_id`,`text`,`created_at`) VALUES ('".$member_id."','".$email."','".$survey_id."','".$question_id."','".$answer_id."','".$text."',now())",$this->connection);
		
	}
}
?>