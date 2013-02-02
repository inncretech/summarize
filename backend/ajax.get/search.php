<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$database  	= new Database();
$info 		= $database->escape($_POST);
$data       = $database->product->getSearchData($info['query']);
$tag_data   = $database->tag->getSearchData($info['query']);

$tmp = $database->product_tag->getByTag($tag_data['id']);
	
foreach ($tmp as $item){
	
	$aux = $database->product->get($item);

	
	array_push($data,$aux);
}
$value = Array();
while (list($key, $val) = each($data)){
	$val['likes'] 		=  $database->product_feedback->getRateDataTotal($val['product_id'],0);
	$val['dislikes'] 	=  $database->product_feedback->getRateDataTotal($val['product_id'],1);
	$product_image_id 	=  $database->product_image->get($val['product_id']);
	$val['image'] 		=  $database->image_table->get($product_image_id);
	array_push($value,$val);
}

echo json_encode($value);
?>