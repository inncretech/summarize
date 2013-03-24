<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$session 			= new Session();
$database  			= new Database();
$member_data 		= $session->get();
$info 				= $database->escape($_POST);
$data       		= $database->product->getSearchData($info['query']);
$tag_data   		= $database->tag->getSearchData($info['query']);
$reported_products 	= $database->report_product->get($member_data['member_id']);

$tmp 				= $database->product_tag->getMultiple($tag_data);


$aux_data = $data;

foreach ($tmp as $item){
	$aux = $database->product->get($item);
	$ok = true;
	
	foreach ($aux_data as $product) if ($item['product_id']==$product['product_id']) $ok = false;
	
	if ((!in_array($aux['product_id'], $reported_products))&&($ok)) array_push($data,$aux);
}

$value 	= Array();
while (list($key, $val) = each($data)){
	$val['seo_title'] 	=  $database->product->getSeoTitle($val['product_id']);
	$val['likes'] 		=  $database->product_feedback->getRateDataTotal($val['product_id'],0);
	$val['dislikes'] 	=  $database->product_feedback->getRateDataTotal($val['product_id'],1);
	$product_image_id 	=  $database->product_image->get($val['product_id']);
	$val['image'] 		=  $database->image_table->get($product_image_id);
	if (!in_array($val['product_id'], $reported_products)) array_push($value,$val);
}
$count = count($value);
for ($i = 0; $i <($count-1); $i++) {
	for ($j = 0; $j <($count-1); $j++) {
		if ($i!=$j) if ($value[$i]['seo_title']=='') $value[$i]=null;
		if ($i!=$j) if ($value[$i]==$value[$j]) $value[$i]=null;
	}
}

$value = array_filter($value);
$value = array_unique($value, SORT_REGULAR);
echo json_encode($value);
?>