<?php
class member
{
	var $connection;
	var $table = "`member`";
	/* Class constructor */
	function member($PDO_connection){
		$this->connection = $PDO_connection;
	}
	
	function getAll(){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table);
		$q->execute();
		return $q->fetchAll();
	}
	
	function checkAdmin($member_id){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table.' WHERE `member_id` = ? AND admin = 1;');
		$q->execute(Array($member_id));
		return $q->rowCount()>0;
	}
	
	function get($member_id){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table." WHERE `member_id`=?");
		$q->execute(array($member_id));
		return $q->fetch();
	}
	
	function getLastId()
	{
		$sql = "SELECT MAX(member_id) FROM ".($this->table);
		$q = $this->connection->query($sql);
		$data = $q->fetch();
		return $data[0];
	}

}
?>