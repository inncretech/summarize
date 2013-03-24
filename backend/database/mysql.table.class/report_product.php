<?php
class report_product
{
	var $connection;
	var $table = "`report_product`";
	/* Class constructor */
	function report_product($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($post)
	{
		$member_id = $post['member_id'];
		$product_id = $post["product_id"];
		mysql_query("INSERT INTO ".($this->table)." (`member_id`,`product_id`,`created_at`) VALUES ('$member_id','$product_id',now())",$this->connection);
	}
	
	function get($member_id)
	{
		$value = Array();
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `member_id`='$member_id' ",$this->connection);
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info['product_id']);
		}
		return $value;
	}
	
	function check($member_id,$product_id)
	{
		
		$data = mysql_query("SELECT * FROM ".$this->table." WHERE `product_id`='$product_id' AND `member_id` = '$member_id'",$this->connection);
		return (mysql_num_rows($data)>0);
	}
}
?>