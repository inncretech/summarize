<?php
class system {
	var $connection;
	var $table = "`system`";

	function system($con){
		$this->connection = $con;
	}	
	function getAll(){
		$result = $this->connection->prepare("SELECT * FROM ".$this->table);
		$result->execute();
		return $result->fetchAll();
	}
}
?>