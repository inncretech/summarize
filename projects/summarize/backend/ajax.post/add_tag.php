<?php
require_once "../constants.php";
require_once "../session.class.php";
$database 		= new Database();
$session		= new Session();
$member_data 	= $session->get();
$data 			= $database->escape($_POST);
$tag_id 		= $database->tag->add($data['tag_name'],$member_data['member_id']);
$database->product_tag->add($tag_id,$data['product_id']);

$product_data 			= $database->product->get($data['product_id']);
$database->member_activity->add($member_data['member_id'],"Tag",$data['tag_name'],$data['product_id'],$product_data['title']);
$database->point->add($member_data['member_id'],"Tag",$data['product_id'],TAG_POINTS);
?>