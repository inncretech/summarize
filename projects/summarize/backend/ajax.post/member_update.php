<?php
require_once "../constants.php";
require_once "../session.class.php";
require_once "../global.functions.php";

$database  		= new Database();
$session    	= new Session();
$member_data 	= $session->get();
$data 			= $database->escape($_POST);
$database->member_info->update($data,$member_data['member_id']);
$database->member->update($data,$member_data["member_id"]);

$info['info'] 		= $database->member_info->get($member_data['member_id']);
$member_image_id    = $database->member_image->get($member_data['member_id']);
$info['image'] 		= $database->image_table->get($member_image_id);

$session->sign_in($info);
?>