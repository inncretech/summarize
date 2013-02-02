<?php
class member
{
	var $connection;
	var $table = "`member`";
	/* Class constructor */
	function member($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function check($post)
	{	
		$key = $post["key"];
		$value = $post["value"];
		
		if ($key=="crypted_password") {$value=md5($value);}
		//if ($key=="password") $value = md5($value);
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `$key`='$value'",$this->connection);
		return (mysql_num_rows($data)>0);
	}
	
	function update($post,$member_id)
	{	
		$login 			= $post["login"];
		$email 			= $post["email"];
		
		$data = mysql_query("UPDATE ".($this->table)." SET `login` = '$login' , `email`= '$email' WHERE `member_id`='$member_id'",$this->connection);
		
	}
	
	function updatePassword($post,$member_id)
	{	
		$password 			= md5($post["crypted_password"]);
		
		$data = mysql_query("UPDATE ".($this->table)." SET `crypted_password` = '$password'  WHERE `member_id`='$member_id'",$this->connection);
		
		
		
	}
	
	function get($member_id)
	{	
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `member_id`='$member_id'",$this->connection);

		return mysql_fetch_array($data);
	}
	
	function checkFacebook($social_network_id)
	{	
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `social_network_id`='$social_network_id'",$this->connection);
		$info = mysql_fetch_array($data);
		return $info;
	}
	
	function add($post)
	{
		$login 				= $post['login'];
		$email 				= $post['email'];
		$password 			= $post['password'];
		$social_network_id 	= $post['social_network_id'];
		$data = mysql_query("INSERT INTO ".($this->table)." (`login`,`email`,`social_network_id`,`crypted_password`,`created_at`) VALUES ('$login','$email','$social_network_id','".md5($password)."',now()); ",$this->connection);
		return $this->getLastId();
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(member_id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
	function getByLogin($login)
	{
		$data = mysql_query("SELECT member_id FROM ".($this->table)." WHERE `login` = '$login'",$this->connection);
		$info = mysql_fetch_array($data);
		return $info;
	}
	
	function check_user($post)
	{		
		$login = $post["login"];
		$crypted_password = md5($post["password"]);
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `login`='$login' AND `crypted_password` = '$crypted_password'",$this->connection);
		if (mysql_num_rows($data)>0){
			$info = mysql_fetch_array($data);
			return $info;
		}else{
			return false;
		}
	}
}
?>