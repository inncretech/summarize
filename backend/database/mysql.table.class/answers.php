<?php
class answers
{
	var $connection;
	var $table = "`answers`";
	/* Class constructor */
	function answers($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($data)
	{
		mysql_query("INSERT INTO ".($this->table)." (`question_id`,`product_id`,`member_id`,`answer_text`,`created_at`) VALUES ('".$data['question_id']."','".$data['product_id']."','".$data['member_id']."','".$data['answer_text']."',now())",$this->connection);
		return $this->getLastId();
	}
	
	function addLike($answer_id)
	{
		mysql_query("UPDATE ".($this->table)." SET total_likes = total_likes + 1 WHERE `answers_id` = '$answer_id'",$this->connection);

	}
	
	function getWeeklyCount()
	{	
		$data = mysql_query("SELECT COUNT(answers_id) FROM ".($this->table)." WHERE created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
AND created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY",$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}

	function addUnlike($answer_id)
	{
		mysql_query("UPDATE ".($this->table)." SET total_unlikes = total_unlikes + 1 WHERE `answers_id` = '$answer_id'",$this->connection);
	}
	
	function getRating($answer_id)
	{
		$data 	= mysql_query("SELECT total_likes,total_unlikes FROM ".($this->table)." WHERE `answers_id` = '$answer_id'",$this->connection);
		return mysql_fetch_array($data);
	}

	function getByQuestion($question_id)
	{
		$data 	= mysql_query("SELECT * FROM ".($this->table)." WHERE `question_id` = '$question_id'",$this->connection);
		$value 	= Array();
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		
		return $value;
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(answers_id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
}
?>