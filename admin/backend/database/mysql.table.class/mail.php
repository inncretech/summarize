<?php
class mail
{
	var $connection;
	var $table = "`mail`";
	/* Class constructor */
	function mail($PDO_connection){
		$this->connection = $PDO_connection;
	}
	
	function add($subject, $message){
		$sql = "INSERT INTO ".($this->table)." (`subject`,`message`) VALUES (?,?); ";
		$q = $this->connection->prepare($sql);
		echo $message;
		return $q->execute(array($subject, $message));
	}
	
	function delete($mail_id){
		$sql = "DELETE FROM ".($this->table)." WHERE `mail_id` = ?; ";
		$q = $this->connection->prepare($sql);
		return $q->execute(array($mail_id));
	}
	
	function getAll(){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table);
		$q->execute();
		return $q->fetchAll();
	}
	
	
	function get($mail_id){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table." WHERE `mail_id`=?");
		$q->execute(array($mail_id));
		return $q->fetch();
	}
	
	function getLastId()
	{
		$sql = "SELECT MAX(mail_id) FROM ".($this->table);
		$q = $this->connection->query($sql);
		$data = $q->fetch();
		return $data[0];
	}

}
?>