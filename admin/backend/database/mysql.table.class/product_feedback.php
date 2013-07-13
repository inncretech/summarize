<?php
class product_feedback
{
	var $connection;
	var $table = "`product_feedback`";
	/* Class constructor */
	function product_feedback($PDO_connection){
		$this->connection = $PDO_connection;
	}
	
	function getVoteCount(){
		$q = $this->connection->prepare('SELECT SUM(total_likes) FROM '.$this->table."");
		$q->execute();
		$data = $q->fetch();
		return intval($data[0]);
	}
	
	function getOpinionCount(){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table."");
		$q->execute();
		return $q->rowCount();
	}
	
	function getUniqueMemberCount(){
		$q = $this->connection->prepare('SELECT COUNT(DISTINCT(created_by)) FROM '.$this->table." ");
		$q->execute();
		$data = $q->fetch();
		return intval($data[0]);
	}
	
	function getLastId()
	{
		$sql = "SELECT MAX(id) FROM ".($this->table);
		$q = $this->connection->query($sql);
		$data = $q->fetch();
		return $data[0];
	}

}
?>