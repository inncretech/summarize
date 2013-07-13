<?php
class product
{
	var $connection;
	var $table = "`product`";
	/* Class constructor */
	function product($mysql_connection)
	{
		$this->connection = $mysql_connection;
	}
	
	function add($post)
	{
		$title 			= preg_replace("/[^ \w]+/", "", trim(preg_replace('/[\s]+/',' ',str_replace('-',' ', $post['title']))));
		$description 	= trim(preg_replace('/[\s]+/',' ',$post['description']));
		$created_by 	= $post['created_by'];
		$public_id		= $post['public_id'];
		$seo_title 		= str_replace(' ','-',preg_replace('/[\s]+/',' ',str_replace('-',' ', $title)));
		
		$data = mysql_query("INSERT INTO ".($this->table)." (`public_id`,`title`,`seo_title`,`description`,`created_by`,`created_at`) VALUES ('$public_id','$title','$seo_title','$description','$created_by',now()); ",$this->connection);
		return $this->getLastId();
	}
	
	function addApp($created_by)
	{
		$data = mysql_query("INSERT INTO ".($this->table)." (`created_by`,`application`,`created_at`) VALUES ('$created_by',1,now()); ",$this->connection);
		return $this->getLastId();
	}
	
	function getAllSeoTitles(){
		$value = Array();
	
		$data = mysql_query("SELECT seo_title FROM ".($this->table)." WHERE `seo_title` IS NOT NULL",$this->connection);
		while($info=mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	
	}
	
	function getWeeklyCount()
	{	
		$data = mysql_query("SELECT COUNT(product_id) FROM ".($this->table)." WHERE created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
AND created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND `application`=0",$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
	function countActive()
	{	
		$data = mysql_query("SELECT COUNT(product_id) FROM ".($this->table),$this->connection." WHERE `application`=0");
		$info = mysql_fetch_array($data);
		return $info[0];
	}
	
	function get($product_id)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `product_id` = '$product_id' AND `application`=0",$this->connection);
		return mysql_fetch_array($data);
	}
	
	function getSeoTitle($product_id)
	{
		$data = mysql_query("SELECT `seo_title` FROM ".($this->table)." WHERE `product_id` = '$product_id' AND `application`=0",$this->connection);
		$data = mysql_fetch_array($data);
		return $data[0];
	}
	
	function getRandom($limit)
	{	
		$value = Array();
	
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `application`=0 ORDER BY RAND() LIMIT ".$limit,$this->connection);
		while($info=mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	
	function getCreatedBy($created_by,$limit)
	{	
		$value = Array();
	
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `created_by`='$created_by' AND `application`=0 ORDER BY created_at DESC LIMIT ".$limit,$this->connection);
		while($info=mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	function getRandomCreated($created_by,$limit)
	{	
		$value = Array();
	
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `created_by`='$created_by' AND `application`=0 ORDER BY RAND() LIMIT ".$limit,$this->connection);
		while($info=mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	function getRandomCreatedBy($member_id,$limit)
	{	
		$value = Array();
	
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `created_by` = '$member_id' AND `application`=0 ORDER BY RAND() LIMIT ".$limit,$this->connection);
		while($info=mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}	
	
	function getAutoSearchData($query)
	{
		$data = mysql_query("SELECT product_id,title FROM ".($this->table)." WHERE `title` LIKE '%".$query."%' AND `application`=0",$this->connection);
		
		$values = Array();
		while ($info = mysql_fetch_array($data)){
			$aux = Array();
			$aux['product_id']	=$info['product_id'];
			$aux['title']		=$info['title'];
			array_push($values,$aux);
		}
		return $values;
	}
	
	function checkSeoTitle($seo_title)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `seo_title`='$seo_title' AND `application`=0",$this->connection);
		if (mysql_num_rows($data)>0){
			$info = mysql_fetch_array($data);
			return $info;
		}
		return false;
	}
	
	function getByTitle($title)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `title` LIKE '%".$title."%' AND `application`=0",$this->connection);
		if (mysql_num_rows($data)>0){
			$info = mysql_fetch_array($data);
			return $info['seo_title'];
		}
		return false;
	}
	
	
	function getSearchData($query)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `title` LIKE '%".$query."%' AND `application`=0",$this->connection);
		
		$values = Array();
		while ($info = mysql_fetch_array($data)){
			
			array_push($values,$info);
		}
		return $values;
	}
	
	function getRecentlyAdded($start,$limit){
		$value = Array();
	
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `application`=0 ORDER BY created_at DESC LIMIT ".$start.",".$limit,$this->connection);
		
		while($info=mysql_fetch_array($data)){
			array_push($value,$info);
		}
		return $value;
	}
	
	function check($title)
	{
		$data = mysql_query("SELECT * FROM ".($this->table)." WHERE `title`='".$title."' AND `application`=0",$this->connection);
		$info = mysql_fetch_array($data);
		return $info['product_id'];
	}
	
	function getLastId()
	{
		$data = mysql_query("SELECT MAX(product_id) FROM ".($this->table)." WHERE `application`=0",$this->connection);
		$info = mysql_fetch_array($data);
		return $info[0];
	}
}
?>