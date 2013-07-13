<?php
class member_info
{
	var $connection;
	var $table = "`member_info`";
	/* Class constructor */
	function member_info($PDO_connection)
	{
		$this->connection = $PDO_connection;
	}
	
	function getAll($start,$limit){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table.' LIMIT '.$start.','.$limit);
		$q->execute();
		return $q->fetchAll();
	}

	function get($member_id){
		$q = $this->connection->prepare('SELECT * FROM '.$this->table." WHERE `member_id`=?");
		$q->execute(array($member_id));
		return $q->fetch();
	}
}
?>