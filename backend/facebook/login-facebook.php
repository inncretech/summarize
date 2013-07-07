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
	$data = $facebook->data;
	$member_id = $database->member->checkMemberFb($data['id']);

	if ($member_id != "false"){
		$session->refresh();
		$session->setValue("social_network_name","facebook");
		$session->setValue("social_network_data",$facebook->data);
		$session->setValue("social_network_id",$facebook->social_network_id);
		
		Redirect(SITE_ROOT."/index.php");
	}else{
		$session->setValue("social_network_name","facebook");
		$session->setValue("social_network_data",$facebook->data);
		$session->setValue("social_network_id",$facebook->social_network_id);
		$database->facebook_friend->add($friends,$member_data['member_id']);
		
		
		Redirect(SITE_ROOT."/backend/ajax.post/add_member.php");
	}
}else{
	$loginUrl 	= $facebook->getLoginUrl();
	Redirect($loginUrl);
}
?>
