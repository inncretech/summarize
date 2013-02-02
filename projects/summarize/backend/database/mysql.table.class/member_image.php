<?php
class member_image
{
	var $connection;
	var $table = "`member_image`";
	/* Class constructor */
	function member_image($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($image_id,$member_id)
	{
		mysql_query("DELETE FROM ".($this->table)." WHERE `member_id`='$member_id'",$this->connection);
		$data = mysql_query("INSERT INTO ".($this->table)." (`image_id`,`member_id`,`created_at`) VALUES ('$image_id','$member_id',now()); ",$this->connection);
		return $this->getLastId();
	}
	
	function get($member_id)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `member_id`='$member_id'",$this->connection);
		$info = mysql_fetch_array($data);
		return $info['image_id'];
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>