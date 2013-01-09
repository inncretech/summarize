<?php
class reference_question
{
	var $connection;
	var $table = "`reference_question`";
	/* Class constructor */
	function reference_question($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function getAll(){
		$array = array();
		$data = mysql_query("SELECT * FROM ".($this->table),$this->connection);
		while ($info = mysql_fetch_array($data)){
			array_push($array, $info);
		}
		return json_encode($array);
	}
}
?>