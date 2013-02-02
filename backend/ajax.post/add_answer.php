<?php
include "../constants.php";
include "../session.class.php";

$database  				= new Database();
$session				= new Session();
$member_data 			= $session->get();			
$data 					= $database->escape($_POST);
$data['member_id']		= $member_data['member_id'];
$answer_id 				= $database->answers->add($data);
$ans_rating 			= $database->answers->getRating($answer_id );
$aux 					= Array();
$aux['total_likes']		= $ans_rating['total_likes'];
$aux['total_unlikes']	= $ans_rating['total_unlikes'];
$aux['answers_id']		= $answer_id;
$aux['login']			= $member_data['login'];
$aux['member_id']		= $member_data['member_id'];

$product_data 			= $database->product->get($data['product_id']);

$database->point->add($member_data['member_id'],"Answer",$data['product_id'],ANSWER_POINTS);
$database->member_activity->add($member_data['member_id'],"Answer",$data['answer_text'],$data['product_id'],$product_data['title']);

echo json_encode($aux);
?>