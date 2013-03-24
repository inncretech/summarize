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
$data['login']				= time();
$data['password']			= md5(time());
$data['member_id'] 			= $database->member->add($data);

$session->sign_in($data);
$database->member_info->add($data);
$database->member_image->add(0,$data['member_id']);


$ses = new AmazonEmail();
$subject = "SummarizIt.com Registration";
$message = "Welcome to SummarizIt.com here are you credentials:\n Username: ".$data['login']."\n Password: ".$data['password'] ;
$ses->send($data["email"],$subject,$message);
?>