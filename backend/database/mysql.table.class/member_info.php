<?php
class member_info
{
	var $connection;
	var $table = "`member_info`";
	/* Class constructor */
	function member_info($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($post)
	{
		$login = $post['login'];
		$email = $post['email'];
		$first_name = $post['first_name'];
		$last_name = $post['last_name'];
		$short_bio = $post['short_bio'];
		$ref_secret_question1_id = $post['ref_secret_question1_id'];
		$secret_answer1_hash = $post['secret_answer1_hash'];
		$member_id = $post['member_id'];
		$data = mysql_query("INSERT INTO ".($this->table)." (`member_id`,`login`,`email`,`first_name`,`last_name`,`short_bio`,`ref_secret_question1_id`,`secret_answer1_hash` , `created_at`) VALUES ('$member_id','$login','$email','$first_name','$last_name','$short_bio','$ref_secret_question1_id','$secret_answer1_hash', now()); ",$this->connection);
		return $data;
	}
	
	function update($post,$member_id)
	{	
		$login 			= $post["login"];
		$email 			= $post["email"];
		$short_bio 		= $post["short_bio"];
		$first_name 	= $post["first_name"];
		$last_name 		= $post["last_name"];
		
		$data = mysql_query("UPDATE ".($this->table)." SET `short_bio` = '$short_bio' ,`first_name` = '$first_name' ,`last_name` = '$last_name' ,`login` = '$login' , `email`= '$email' WHERE `member_id`='$member_id'",$this->connection);
		
	}
	
	function get($member_id)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `member_id`='$member_id'",$this->connection);
		return mysql_fetch_array($data);
	}

}
?>