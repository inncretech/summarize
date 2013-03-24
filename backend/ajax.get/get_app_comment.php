<?php
include "../constants.php";
include "../session.class.php";
include "../email.system/amazon.email.php";
include "../global.functions.php";
include "../image.class/global.functions/SimpleImage.php";
include "../image.class/amazon.class/s3.php";

$database = new Database();
$session  = new Session();
$facebook = new Fb();
$twitter  = new Tw();
$data						= $database->escape($_POST);


$info						= $database->application_thread_comment->get($data);
$value						= Array();
foreach ($info as $item){
	$member_data 			= $database->member->get($item['created_by']);
	$item['member_data'] 	= $member_data;
	array_push($value,$item);
}

echo json_encode($value);

?>