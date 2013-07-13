<?php
class tag
{
	var $connection;
	var $table = "`tag`";
	/* Class constructor */
	function tag($PDO_connection){
		$this->connection = $PDO_connection;
	}
	
	function getCount(){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table."");
		$q->execute();
		return $q->rowCount();
	}
	
	function getLastId()
	{
		$sql = "SELECT MAX(tag_id) FROM ".($this->table);
		$q = $this->connection->query($sql);
		$data = $q->fetch();
		return $data[0];
	}

}
?>