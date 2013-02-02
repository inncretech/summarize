<?php
class view_details
{
	var $connection;
	var $table = "`view_details`";
	/* Class constructor */
	function view_details($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($product_id,$member_id)
	{
		mysql_query("INSERT INTO ".($this->table)." (`viewed_product_id`,`member_id`,`created_at`) VALUES ('$product_id','$member_id',now())");
	}
	
	function getMostViewed($start,$limit){
		$value = Array();
	
		$data = mysql_query("SELECT DISTINCT(viewed_product_id),COUNT(`viewed_product_id`) FROM ".($this->table)." GROUP BY `viewed_product_id` ORDER BY COUNT(`viewed_product_id`) DESC LIMIT ".$limit,$this->connection);
		
		while($info=mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
}
?>