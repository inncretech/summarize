<?php
include "../session.class.php";
include "../global.functions.php";

$database  				= new Database();
$session   				= new Session();
$member_data			= $session->get();
$_POST['created_by'] 	= $member_data['member_id'];
$data 					= $database->escape($_POST);
$data['feedback_id'] 	= $database->product_feedback->add($data);
$product_data 			= $database->product->get($data['product_id']);

$database->point->add($member_data['member_id'],"Feedback",$data['product_id'],FEEDBACK_POINTS);
$database->member_activity->add($member_data['member_id'],"Feedback",$data['comment'],$data['product_id'],$product_data['public_id'],$product_data['title']);

echo $data['feedback_id'];
?>