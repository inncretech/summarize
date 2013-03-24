<?php
include "../constants.php";
include "../session.class.php";

$database  			= new Database();
$session			= new Session();
$member_data 		= $session->get();			
$data 				= $database->escape($_POST);
$data['member_id']	= $member_data['member_id'];

$database->questions->add($data);

$product_data 		= $database->product->get($data['product_id']);

$database->point->add($member_data['member_id'],"Question",$data['product_id'],QUESTION_POINTS);
$database->member_activity->add($member_data['member_id'],"Question",$data['question_text'],$data['product_id'],$product_data['public_id'],$product_data['title']);
?>