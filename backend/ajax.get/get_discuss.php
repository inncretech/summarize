<?php
include "../constants.php";
include "../session.class.php";

$database  			= new Database();			
$data 				= $database->escape($_POST);
$discuss 			= $database->questions->getByProduct($data['product_id']);
$data 				= Array();
foreach ($discuss as $item){
	$aux = Array();
	$aux['question'] 	= $item;
	$info 				= $database->answers->getByQuestion($item['question_id']);
	$tmp 				= Array();
	foreach ($info as $item){
		$member_data 		= $database->member->get($item['member_id']);
		$item['login'] 		= $member_data['login'];
		$item['seo_title']	= $member_data['seo_title'];
		array_push($tmp,$item);
	}
	$aux['answers'] = $tmp;
	array_push($data,$aux);
}
echo json_encode($data);
?>