<?php
include "../constants.php";
include "../session.class.php";

$database  			= new Database();
$session			= new Session();
$member_data 		= $session->get();			
$data 				= $database->escape($_POST);
$data['member_id']	= $member_data['member_id'];

if ($database->member_answer->check($data)){
	$product_data 		= $database->product->get($data['product_id']);
	$database->point->add($member_data['member_id'],"Answer Rate",$data['product_id'],ANSWER_RATE_POINTS);
	$database->member_activity->add($member_data['member_id'],"Answer Rate",$data['answer_text'],$data['product_id'],$product_data['title']);
	$database->member_answer->add($data);
	if ($_POST['type']==0){
		$database->answers->addLike($data['answer_id']);
	}else{
		$database->answers->addUnlike($data['answer_id']);
	}
}
?>