<?php
class tag
{
	var $connection;
	var $table = "`tag`";
	/* Class constructor */
	function tag($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($tag_name,$created_by)
	{
		$check_data = mysql_query("SELECT * FROM ".($this->table)." WHERE `tag_name`='$tag_name'",$this->connection);
		if (mysql_num_rows($check_data)>0){
			$check_info = mysql_fetch_array($check_data);
			return $check_info['id'];
		}else{
			$data = mysql_query("INSERT INTO ".($this->table)." (`tag_name`,`created_by`,`created_at`) VALUES ('$tag_name','$created_by',now()); ",$this->connection);
			return $this->getLastId();
		}
		
	}
	
	function getSearchData($query)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `tag_name` LIKE '%".$query."%'",$this->connection);
		$info = mysql_fetch_array($data);
		
		return $info;
	}
	
	function getMultiple($tag_id_array)
	{
		$tag_name = Array();
		foreach ($tag_id_array as $id){
			$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `id` = $id",$this->connection);
			$info = mysql_fetch_array($data);
			array_push($tag_name,$info['tag_name']);
		}
		
		return array_unique($tag_name);
	}
	
	function getByName($tag_name)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `tag_name` = '$tag_name'",$this->connection);
		$info = mysql_fetch_array($data);
		return $info;
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
	
}
?>