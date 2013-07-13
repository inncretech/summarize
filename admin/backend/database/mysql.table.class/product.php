<?php
class product
{
	var $connection;
	var $table = "`product`";
	/* Class constructor */
	function product($PDO_connection){
		$this->connection = $PDO_connection;
	}
	
	function getAll(){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table);
		$q->execute();
		return $q->fetchAll();
	}
	
	function getCount(){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table."");
		$q->execute();
		return $q->rowCount();
	}
	
	function get($member_id){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table." WHERE `member_id`=?");
		$q->execute(array($member_id));
		return $q->fetch();
	}
	
	function getLastId()
	{
		$sql = "SELECT MAX(product_id) FROM ".($this->table);
		$q = $this->connection->query($sql);
		$data = $q->fetch();
		return $data[0];
	}

}
?>