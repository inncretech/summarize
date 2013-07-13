<?php
include "../constants.php";
include "../session.class.php";
$database 		= new Database();
$session 		= new Session();
$data			= $database->escape($_POST);
$info 			= $database->product->getCreatedBy($data['member_id'],$data['limit']);

for ($i = 0; $i <count($info); $i++) {
	$info[$i]['seo_title']	=  $database->product->getSeoTitle($info[$i]['product_id']);
	$info[$i]['likes'] 		=  $database->product_feedback->getRateDataTotal($info[$i]['product_id'],0);
	$info[$i]['dislikes'] 	=  $database->product_feedback->getRateDataTotal($info[$i]['product_id'],1);
	$product_image_id 		=  $database->product_image->get($info[$i]['product_id']);
	
	$info[$i]['image'] 		=  $database->image_table->get($product_image_id);
}
echo json_encode($info);
?>