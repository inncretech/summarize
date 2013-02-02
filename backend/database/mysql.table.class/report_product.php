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
	
	function check($member_id,$product_id)
	{
		
		$data = mysql_query("SELECT * FROM ".$this->table." WHERE `product_id`='$product_id' AND `member_id` = '$member_id'",$this->connection);
		return (mysql_num_rows($data)>0);
	}
}
?>