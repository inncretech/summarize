<?php
class application_thread
{
	var $connection;
	var $table = "`application_thread`";
	/* Class constructor */
	function application_thread($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function getProductId($app_id,$custom_thread_id)
	{
		$data = mysql_query("SELECT `product_id` FROM ".($this->table)." WHERE `application_id` = '".$app_id."' AND `custom_thread_id` = '".$custom_thread_id."'",$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
	function checkThread($app_id,$custom_thread_id)
	{
		$info = mysql_query("SELECT * FROM ".($this->table)." WHERE `application_id` = '".$app_id."' AND `custom_thread_id` = '".$custom_thread_id."'",$this->connection);
		return (mysql_num_rows($info)>0);
	}
	function add($app_id,$custom_thread_id,$product_id,$created_by){
		mysql_query("INSERT INTO ".($this->table)." (`application_id`,`custom_thread_id`,`product_id`,`created_by`) VALUES ('$app_id','$custom_thread_id','$product_id','$created_by'); ",$this->connection);
	}

}
?>