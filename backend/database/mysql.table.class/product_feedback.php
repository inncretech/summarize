<?php
class product_feedback
{
	var $connection;
	var $table = "`product_feedback`";
	/* Class constructor */
	function product_feedback($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($post)
	{
		$category 		= $post['category'];
		$product_id 	= $post['product_id'];
		$comment		= $post['comment'];
		$type 			= $post['type'];
		$created_by 	= $post['created_by'];
		$data = mysql_query("INSERT INTO ".($this->table)." (`product_id`,`category`,`comment`,`type`,`created_by`,`created_at`) VALUES ('$product_id','$category','$comment','$type','$created_by',now()); ",$this->connection);
		return $this->getLastId();
	}
	
	function getCateogiresByQueryAndProduct($query)
	{
		$value 	= Array();
		$query  = explode(" ", $query);
		$code	= " 1=2 ";
		foreach ($query as $item){
			$code .= " OR `category` LIKE '%".$item."%' ";
		}
		
		$data 	= mysql_query("SELECT category FROM ".($this->table)." WHERE ".$code." ",$this->connection);
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info[0]);
		}
		return $value;
		
	}
	
	function getTopFeedback($product_id)
	{
		
		$data 	= mysql_query("SELECT * FROM ".$this->table."  WHERE (SELECT MAX(total_likes+total_unlikes) FROM ".$this->table." WHERE `product_id` = '".$product_id."' ) = (total_likes+total_unlikes) AND `product_id` = '".$product_id."' GROUP BY feedback_id",$this->connection);
		return mysql_fetch_array($data);
		
	}
	
	function getByProduct($product_id)
	{
		$data = Array();
		$category_data = mysql_query("SELECT DISTINCT(category) FROM ".($this->table)." WHERE `product_id`='".$product_id."' ",$this->connection);
		while ($category_info = mysql_fetch_array($category_data)){
			$row_data 		= Array();
			$feedback_row_data 	= Array();
			$row_data['category']= $category_info[0];
			
			$info = mysql_query("SELECT SUM(total_likes) FROM ".($this->table)." WHERE `category`='".$category_info[0]."' AND `product_id` = '$product_id'  AND `type` = '0'",$this->connection);
			$info = mysql_fetch_array($info);
			$row_data['thumbs_up']= $info[0];
			
			$info = mysql_query("SELECT SUM(total_likes) FROM ".($this->table)." WHERE `category`='".$category_info[0]."' AND `product_id` = '$product_id'  AND `type` = '1'",$this->connection);
			$info = mysql_fetch_array($info);
			$row_data['thumbs_down']= $info[0];
			
			$feedback_data = mysql_query("SELECT * FROM ".($this->table)." WHERE `product_id`='".$product_id."' AND `category` = '".$category_info[0]."' AND `product_id` = '$product_id' ",$this->connection);
			while ($feedback_info = mysql_fetch_array($feedback_data)){
				array_push($feedback_row_data,$feedback_info);
			}
			$row_data['feedback']= $feedback_row_data;
			array_push($data,$row_data);
		}
		return $data;
	}
	
	function getById($feedback_id)
	{
		
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `feedback_id`='".$feedback_id."'",$this->connection);
		return mysql_fetch_array($data);
	}
	
	function changeCategory($old_category,$new_category,$product_id)
	{
		$data = mysql_query("UPDATE ".($this->table)." SET `category`='$new_category' WHERE `category`='$old_category' AND `product_id` = '$product_id'",$this->connection);
	}
	
	function getWeeklyCount()
	{	
		$data = mysql_query("SELECT COUNT(feedback_id) FROM ".($this->table)." WHERE created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
AND created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY",$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
	function updateLike($feedback_id,$product_id)
	{
		$data = mysql_query("UPDATE ".($this->table)." SET total_likes = total_likes+1 WHERE `feedback_id`='$feedback_id' AND `product_id` = '$product_id'",$this->connection);
	}
	
	function getHighestRated($start,$limit)
	{	
		$value = Array();
	
		$data = mysql_query("SELECT product_id FROM ".($this->table)." GROUP BY product_id ORDER BY SUM(total_likes+total_unlikes) DESC LIMIT ".$start.",".$limit,$this->connection);
		
		while($info=mysql_fetch_array($data)){
			
			array_push($value,$info);
		}
		
		return $value;
	}
	
	
	function getLikeCount($feedback_id,$product_id){
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `feedback_id`='$feedback_id' AND `product_id` = '$product_id'",$this->connection);
		$info = mysql_fetch_array($data);
		return $info['total_likes'];
	}
	
	function getLatest($limit)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." ORDER BY created_at DESC LIMIT 0,".$limit,$this->connection);
		$value = Array();
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	function getCategories($product_id)
	{
		$data = mysql_query("SELECT DISTINCT(category) FROM ".($this->table)." WHERE `product_id` = '$product_id' ORDER BY category",$this->connection);
		$value = Array();
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info[0]);
		}
		return $value;
	}
	
	function getRateData($product_id,$type)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `product_id` = '$product_id' ORDER BY category",$this->connection);
		$value = Array();
		
		$info = mysql_fetch_array($data);
		$current_category = $info['category'];
		if ($info['type']==$type) $current_count = $info['total_likes']; else $current_count = 0;

		while ($info = mysql_fetch_array($data)){
			
			if	($current_category==$info['category']) {
				if ($info['type']==$type) $current_count = $current_count+$info['total_likes'];
			}else{		
				array_push($value,$current_count);
				if ($info['type']==$type) $current_count = $info['total_likes']; else $current_count = 0;
				$current_category = $info['category'];
			}
		}
		array_push($value,$current_count);
		return $value;
	}
	
	
	function getRateDataTotal($product_id,$type)
	{
		$data 	= mysql_query("SELECT SUM(total_likes) FROM ".($this->table)." WHERE `product_id` = '$product_id' AND `type`='$type' ",$this->connection);
		$info = mysql_fetch_array($data);
		
		return $info[0];
	}
	
	function getProductsByCategory($category)
	{
		
		$product_id = Array();
		$data = mysql_query("SELECT DISTINCT(product_id) FROM ".($this->table)." WHERE `category`='$category'",$this->connection);
		While ($info = mysql_fetch_array($data)){
			array_push($product_id,$info[0]);
		}
		return $product_id;
	}
	
	
	function getAutoSearchData($query,$product_id)
	{
		$data = mysql_query("SELECT category FROM ".($this->table)." WHERE  `product_id` = '$product_id' AND `category` LIKE '%".$query."%'",$this->connection);
		
		$value = Array();
		while ($info = mysql_fetch_array($data)){
			array_push($value,$info['category']);
		}
		
		return array_unique($value);
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(feedback_id) FROM ".($this->table),$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>