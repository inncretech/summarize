<?php
require_once "../session.class.php";
require_once "../global.functions.php";

$database  				= new Database();
$session   				= new Session();
$user_data			    = $session->get();
$_POST['created_by'] 	= $user_data['member_id'];
$data 					= $database->escape($_POST);
$data['feedback_id'] 	= $database->product_feedback->add($data);
$product_data 			= $database->product->get($data['product_id']);

$database->point->add($user_data['member_id'],"Feedback",$data['product_id'],FEEDBACK_POINTS);
$database->member_activity->add($user_data['member_id'],"Feedback",$data['comment'],$data['product_id'],$product_data['title']);

echo "true";
?>