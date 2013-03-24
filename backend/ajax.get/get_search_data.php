<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$database  	= new Database();
$session 			= new Session();
$member_data 		= $session->get();
$reported_products 	= $database->report_product->get($member_data['member_id']);
$data 				= $database->escape($_GET);
if (isset($data['tag'])) $tags 	= $database->tag->getByQuery($data['query']);
$info       		= $database->product->getAutoSearchData($data['query']);

$value				= Array();

foreach ($info as $item){
	$item['seo_title'] = $database->product->getSeoTitle($item['product_id']);
	$item['type'] = "product";
	if (!in_array($item['product_id'], $reported_products)) array_push($value,$item);
}


if (isset($data['tag'])){
	foreach ($tags as $item){
		$aux = Array();
		$aux['seo_title'] = "";
		$aux['type'] = "tag";
		$aux['title'] = $item;
		array_push($value,$aux);
	}
}

$value 	= array_slice($value, 0, 5);

echo json_encode($value);
?>