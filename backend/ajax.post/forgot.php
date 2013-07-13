<?php
include "../session.class.php";
include "../email.system/amazon.email.php";

$session 		= new Session();
$database 		= new Database();
$facebook		= new Fb();
$member_data 	= $session->get();
$member_info    = $database->member_info->get($member_data['member_id']);

$ok = false;
if ($_POST['email']!=''){
	if ($database->member->checkEmail($_POST['email'])){
		$member = $database->member->getByEmail($_POST['email']);
		
		$password['crypted_password'] = time();
		$database->member->updatePassword($password,$member['member_id']);
		echo sendMail($member['email'],'SummarizIt Forgot Password','Your new password is: '.$password['crypted_password']);
		$ok = true;
	}
}
if ($_POST['login']!=''){
	if ($database->member->checkLogin($_POST['login'])){
		$member = $database->member->getByLogin($_POST['login']);
		$password['crypted_password'] = time();
		
		$database->member->updatePassword($password,$member['member_id']);
		echo sendMail($member['email'],'SummarizIt Forgot Password','Your new password is: '.$password['crypted_password']);
		$ok = true;
	}
}
function sendMail($to,$subject,$message){
	$ses 		= new  AmazonEmail();
	$ses->send($to,$subject,$message);
}

if ($ok) echo 'true'; else echo 'false';
?>


