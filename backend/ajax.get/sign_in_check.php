<?php
include "../session.class.php";
$database = new Database();
$data = $database->escape($_POST);
$info = $database->member->check_user($data);
 
if ($info == false){
	echo "false";	
}else{
	
	
	$session 			= new Session();
	
	$info['info'] 		= $database->member_info->get($info['member_id']);
	$member_image_id    = $database->member_image->get($info['member_id']);
	$info['image'] 		= $database->image_table->get($member_image_id);
	
	$session->sign_in($info);
	$session->setValue("next",$data["next"]);
	echo "true";
}
?>