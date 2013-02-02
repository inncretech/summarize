<?php
require_once "../session.class.php";
require_once "../global.functions.php";

$database  				= new Database();
$session   				= new Session();
$member_data			    = $session->get();
$_POST['created_by'] 	= $member_data['member_id'];
$data 					= $database->escape($_POST);
$product_id 			= $database->product->add($data);
$image_id				= $database->image_table->add($data);

$database->point->add($member_data['member_id'],"Product",$product_id,PRODUCT_POINTS);
$database->product_image->add($image_id,$product_id);

foreach ($data['tags'] as $tag_name){
	$tag_id = $database->tag->add($tag_name,$_POST['created_by']);
	$database->product_tag->add($tag_id,$product_id);
}

echo $product_id;

?>