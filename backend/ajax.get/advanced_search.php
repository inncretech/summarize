<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$session 			= new Session();
$database  			= new Database();
$member_data 		= $session->get();
$info 				= $database->escape($_POST);
$query				= explode(" ",$info['query']);
$data				= Array();
$tag_data			= Array();
$product_data		= Array();
foreach ($query as $item){
	if ($item!=''){
		$product_data       = array_merge ($product_data,$database->product->getSearchData($item));
		$tag_data   		= array_merge ($tag_data,$database->tag->getSearchData($item));
	}
}

$reported_products 	= $database->report_product->get($member_data['member_id']);
$tmp 				= $database->product_tag->getByMultipleTags($tag_data);


$aux_data = $product_data;

foreach ($tmp as $item){
	$aux = $database->product->get($item);
	$ok = true;
	
	foreach ($aux_data as $product) if ($item['product_id']==$product['product_id']) $ok = false;
	
	if ((!in_array($aux['product_id'], $reported_products))&&($ok)) array_push($product_data,$aux);
}

$value 	= Array();
while (list($key, $val) = each($product_data)){
	if (!in_array($val['product_id'], $reported_products)) array_push($value,$val);
}

if (!isset($_GET['categories'])){
	$aux = Array();
	while (list($key, $val) = each($value)){
		$aux = array_merge($aux,$database->product_feedback->getCategories($val['product_id']));
	}


	$aux = array_unique($aux);

	echo json_encode($aux);
}else{
	
	$array = Array();
	
	while (list($key, $val) = each($value)){
		$categories = $database->product_feedback->getCategories($val['product_id']);
		
		if (count(array_intersect($info['categories'], $categories))>0){
			array_push($array,$val);
		}
	}
	$aux = Array();
	$prod_id = Array();
	while (list($key, $val) = each($array)){
		if (!in_array($val['product_id'],$prod_id)){
			array_push($prod_id,$val['product_id']);
			$val['seo_title'] 	=  $database->product->getSeoTitle($val['product_id']);
			$val['likes'] 		=  $database->product_feedback->getRateDataTotal($val['product_id'],0);
			$val['dislikes'] 	=  $database->product_feedback->getRateDataTotal($val['product_id'],1);
			$product_image_id 	=  $database->product_image->get($val['product_id']);
			$val['image'] 		=  $database->image_table->get($product_image_id);
			array_push($aux,$val);
		}
	}
	
	echo json_encode($aux);
}
?>