<?php
include "../constants.php";
include "../database/database.class.php";
$database 	= new Database();
$data 		= $database->escape($_POST);
$data 		= $database->product->getRecentlyAdded($data['start'],$data['limit']);


for ($i = 0; $i <count($data); $i++) {

	$data[$i]['seo_title']  =  $database->product->getSeoTitle($data[$i]['product_id']);
	$data[$i]['likes'] 		=  $database->product_feedback->getRateDataTotal($data[$i]['product_id'],0);
	$data[$i]['dislikes'] 	=  $database->product_feedback->getRateDataTotal($data[$i]['product_id'],1);
	$product_image_id 		=  $database->product_image->get($data[$i]['product_id']);

	$data[$i]['image'] 		=  $database->image_table->get($product_image_id);
}
echo json_encode($data);
?>