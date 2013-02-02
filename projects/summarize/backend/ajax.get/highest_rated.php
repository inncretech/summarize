<?php
require_once "../constants.php";
require_once "../database/database.class.php";
$database 	= new Database();

$info 		= $database->product->getRandom(3);

for ($i = 0; $i <count($info); $i++) {
	$info[$i]['likes'] 		=  $database->product_feedback->getRateDataTotal($info[$i]['product_id'],0);
	$info[$i]['dislikes'] 	=  $database->product_feedback->getRateDataTotal($info[$i]['product_id'],1);
	$product_image_id 		=  $database->product_image->get($info[$i]['product_id']);
	
	$info[$i]['image'] 		=  $database->image_table->get($product_image_id);
}
echo json_encode($info);
?>