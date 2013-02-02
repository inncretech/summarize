<?php
include "../constants.php";
include "../session.class.php";
include "../email.system/amazon.email.php";
include "../global.functions.php";
$database = new Database();
$session  = new Session();
$facebook = new Fb();

$data 						= $database->escape($_POST);

$data["social_network_id"] 	= $facebook->data['id'];
$data['member_id'] 			= $database->member->add($data);
$database->member_info->add($data);
$database->member_image->add(0,$data['member_id']);




$ses = new AmazonEmail();
$subject = "SummarizIt.com Registration";
$message = "Welcome to SummarizIt.com here are you credentials:\n Username: ".$data['login']."\n Password: ".$data['password'] ;
$ses->send($data["email"],$subject,$message);

Redirect("../../index.php?sign_out=true");
?>