<?php
class Users
{
	var $connection;
	var $table = "`users`";
	/* Class constructor */
	function Users($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	/**
	* confirmUserPass - Checks whether or not the given
	* username is in the database, if so it checks if the
	* given password is the same password in the database
	* for that user. If the user doesn't exist or if the
	* passwords don't match up, it returns an error code
	* (1 or 2). On success it returns 0.
	*/
	function confirm($username, $password ){
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		/* Add slashes if necessary (for query) */
		if(!get_magic_quotes_gpc()) {
		  $username = addslashes($username);
		}
		/* Verify that user is in database */
		$query = "SELECT * FROM ".($this->table)." WHERE `username` = '".$username."'";
		$data = mysql_query($query, $this->connection);
		if(!$data || (mysql_num_rows($data) < 1)){
			return 1; //Indicates username failure
		}

		/* Retrieve password from result, strip slashes */
		$info = mysql_fetch_array($data);
		$info['password'] = stripslashes($info['password']);
		$password = stripslashes($password);
		/* Validate that password is correct */
		if($password == $info['password']){
			return 0; //Success! Username and password confirmed
		}
		else{
			return 2; //Indicates password failure
		}
	}
	/**
	* userEmailTaken - Returns true if the username has
	* been taken by another user, false otherwise.
	*/
	function checkEmail($email){
		$email = mysql_real_escape_string($email);
		if(!get_magic_quotes_gpc()){
			$email = addslashes($email);
		}
		$q = "SELECT `email` FROM ".($this->table)." WHERE `email` = '".$email."'";
		$result = mysql_query($q, $this->connection);
		return (mysql_numrows($result) > 0);
	}
	
	function update($uid,$params){
		$query = "UPDATE ".($this->table)." SET ";
		foreach ($params as $key => $value){
			$value  = mysql_real_escape_string($value);
			$query .= "`".$key."` = '".$value."',";
		}
		$query  = substr_replace($query ,"",-1);
		$query .= "WHERE `uid` = '".$uid."'";
		mysql_query($query, $this->connection);
	}
}


?>