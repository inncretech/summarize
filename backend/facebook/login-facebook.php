<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$session 	= new Session();
$database 	= new Database();
$facebook 	= new Fb();

$member_data 	= $database->member->checkSocialNetwork($facebook->social_network_id);
$friends 		= $facebook->friends;


if ($facebook->check){
	$session->setValue("social_network_name","facebook");
	$session->setValue("social_network_data",$facebook->data);
	$session->setValue("social_network_id",$facebook->social_network_id);
	$database->facebook_friend->add($friends,$member_data['member_id']);
	
	
	Redirect("../../index.php");
}else{
	$loginUrl 	= $facebook->getLoginUrl();
	Redirect($loginUrl);
}
?>
