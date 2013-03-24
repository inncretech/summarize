<?php
include "../constants.php";
include "../session.class.php";
$database 		= new Database();
$session 		= new Session();

$data 			= $session->getCompareValue();
$info			= Array();
if (!empty($data)){
	$query ="select DISTINCT(category),product_id,(Select title from product as b where a.product_id=b.product_id) as title,IFNULL((Select sum(total_likes) from  product_feedback as b where a.category=b.category and b.type=0 and a.product_id=b.product_id),0) as thumbs_up ,IFNULL((Select sum(total_likes) from  product_feedback as b where a.category=b.category and b.type=1 and a.product_id=b.product_id),0) as thumbs_down from product_feedback as a where ";
	foreach ($data as $key=>$item){
		if($item['check']){
			$id    = $item["product_id"];
			$query = $query."`product_id`='$id' OR ";
		}
	}
	$query=$query." 1=2 ORDER BY thumbs_up,thumbs_down ;";

	$data 		= $database->query($query);
	$value 		= Array();
	$category 	= Array();
	$product 	= Array();
	while ($info = mysql_fetch_array($data)){
		$aux 	= Array();
		$aux['thumbs_up'] 											=  $info['thumbs_up'];
		$aux['thumbs_down'] 										=  $info['thumbs_down'];
		$product[$info['title']]['product_id'] 						= $info['product_id'];
		$product[$info['title']]['category'][$info['category']]		= $aux;
	}


//echo $query;
echo json_encode(array_reverse($product));
}
?>