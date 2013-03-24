<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$database  			= new Database();
$session			= new Session();
$member_data 		= ($session->check() ? $session->get() : null);			
$data 				= $database->escape($_POST);
$info 				= $data;
foreach ($data as $key=>$value){
	$key = explode("-", $key);
	if ($key[0]=="answer"){
		if ($key[1]=="textarea"){
			$database->survey_member_answer->add($member_data['member_id'],$info['email'],$info['survey_id'],$key[2],null,$value);
		}else{
			$database->survey_member_answer->add($member_data['member_id'],$info['email'],$info['survey_id'],$key[1],$value,null);
		}
	}
}
Redirect(SITE_ROOT."/index.php?msg=survey");
?>