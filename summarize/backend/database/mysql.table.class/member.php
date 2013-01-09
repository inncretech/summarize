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
		//if ($key=="password") $value = md5($value);
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `$key`='$value'",$this->connection);
		return (mysql_num_rows($data)>0);
	}
	
	function add($post)
	{
		$login = $post['login'];
		$email = $post['email'];
		$password = $post['password'];
		$data = mysql_query("INSERT INTO ".($this->table)." (`login`,`email`,`crypted_password`,`created_at`) VALUES ('$login','$email','".md5($password)."',now()); ",$this->connection);
		return $this->getLastId();
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
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