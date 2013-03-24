<?php
include "../constants.php";
include "../session.class.php";
$database 		= new Database();
$session 		= new Session();

$data 				= $database->escape($_POST);
$product_id 		= $database->product->check($data['title']);
echo $product_id;
if($product_id  != ""){
	$value = Array();
	$value['check']	 		= true;
	$value['product_id'] 	= $product_id ;
	$value['seo_title']	 	= $database->product->getSeoTitle($product_id);
	$session->setCompareValue($data['title'],$value);
}

?>