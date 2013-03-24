<?php
include "../constants.php";
include "../session.class.php";

$session			= new Session();
$database 			= new Database();
$member_data 		= $session->get();	
$data 				= $database->escape($_POST);
$tag_data 			= $database->tag->getByName($data['tag_name']);
$product_data 		= $database->product->get($data['product_id']);

$database->product_tag->remove($tag_data['id'],$data['product_id']);
$database->member_activity->add($member_data['member_id'],"Tag Remove",$data['tag_name'],$data['product_id'],$product_data['public_id'],$product_data['title']);
?>