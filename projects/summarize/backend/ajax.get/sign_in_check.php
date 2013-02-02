<?php
require_once "../constants.php";
require_once "../database/database.class.php";
$database = new Database();
$data = $database->escape($_POST);
$info = $database->member->check_user($data);
if ($info == false){
	echo "false";	
}else{
	require_once "../session.class.php";
	$session 			= new Session();
	
	$info['info'] 		= $database->member_info->get($info['member_id']);
	$member_image_id    = $database->member_image->get($info['member_id']);
	$info['image'] 		= $database->image_table->get($member_image_id);
	
	$session->sign_in($info);
	echo "true";
}
?>