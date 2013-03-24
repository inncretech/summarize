<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$session 			= new Session();
$database  			= new Database();
$value				= Array();
$data				= $database->product_feedback->getLatest(4);

foreach ($data as $item){
	$item['product_data'] = $database->product->get($item['product_id']);
	$item['product_info'] = $database->product_info->getByProduct($item['product_id']);
	array_push($value,$item);
}
echo json_encode($value);
?>