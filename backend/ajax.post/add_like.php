<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$database  			= new Database();
$session			= new Session();
$member_data 		= $session->get();			
$data 				= $database->escape($_POST);
$check 				= $database->member_feedback->check($data['feedback_id'],$member_data['member_id']);
if (!$check){
	$database->product_feedback->updateLike($data['feedback_id'],$data['product_id']);
	$database->member_feedback->add($data['feedback_id'],$member_data['member_id']);
}
$current_like_count 	= $database->product_feedback->getLikeCount($data['feedback_id'],$data['product_id']);
$product_data 			= $database->product->get($data['product_id']);
$feedback_data			= $database->product_feedback->getById($data['feedback_id']);
$database->member_activity->add($member_data['member_id'],"Like",$feedback_data['comment'],$data['product_id'],$product_data['public_id'],$product_data['title']);
$database->point->add($member_data['member_id'],"Like",$data['product_id'],LIKE_POINTS);

echo $current_like_count;

?>