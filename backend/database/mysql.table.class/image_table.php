<?php
class image_table
{
	var $connection;
	var $table = "`image_table`";
	/* Class constructor */
	function image_table($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($post)
	{
		$full_image_url = $post['full_image_url'];
		$width 			= $post['width'];
		$height 		= $post['height'];
		$created_by 	= $post['created_by'];
		
		$data = mysql_query("INSERT INTO ".($this->table)." (`full_image_url`,`width`,`height`,`created_by`,`created_at`) VALUES ('$full_image_url','$width','$height','$created_by',now()); ",$this->connection);
		
		return $this->getLastId();
	}
	
	function get($product_id)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `id` = '$product_id'",$this->connection);
		return (mysql_fetch_array($data));
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>