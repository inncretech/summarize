<?php
class questions
{
	var $connection;
	var $table = "`questions`";
	/* Class constructor */
	function questions($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($data)
	{
		mysql_query("INSERT INTO ".($this->table)." (`product_id`,`member_id`,`question_text`,`created_at`) VALUES ('".$data['product_id']."','".$data['member_id']."','".$data['question_text']."',now())",$this->connection);
	}
	
	function getWeeklyCount()
	{	
		$data = mysql_query("SELECT COUNT(question_id) FROM ".($this->table)." WHERE created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
AND created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY",$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
	function getByProduct($product_id)
	{
		$data 	= mysql_query("SELECT * FROM ".($this->table)." WHERE `product_id` = '$product_id'",$this->connection);
		$value 	= Array();
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		
		return $value;
	}
}
?>