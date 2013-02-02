<?php
include "../session.class.php";
include "../global.functions.php";

$database  				= new Database();
$session   				= new Session();
$member_data			= $session->get();
$_POST['created_by'] 	= $member_data['member_id'];
$data 					= $database->escape($_POST);
$product_id 			= $database->product->add($data);
$image_id				= $database->image_table->add($data);

$database->product_info->add($data,$product_id);
$database->point->add($member_data['member_id'],"Product",$product_id,PRODUCT_POINTS);
$database->product_image->add($image_id,$product_id);

foreach ($data['tags'] as $tag_name){
	$tag_id = $database->tag->add($tag_name,$_POST['created_by']);
	$database->product_tag->add($tag_id,$product_id);
}
$desc = $data['description'];
if (strlen($desc)>60) $desc = substr($desc,0,60)."...";
$database->member_activity->add($member_data['member_id'],"Product",$desc,$product_id,$data['title']);

echo $product_id;

?>