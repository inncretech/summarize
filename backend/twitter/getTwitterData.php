<?php
include "../constants.php";
include "../global.functions.php";
include "../session.class.php";


$session = new Session();
$twitter = new Tw();

$oauth_verifier 	= $_GET['oauth_verifier'];
$oauth_token 		= $session->getValue('oauth_token');
$oauth_token_secret	= $session->getValue('oauth_token_secret');


if (!empty($oauth_verifier) && !empty($oauth_token) && !empty($oauth_token_secret)) {
	
	$twitter->getUserData($oauth_verifier,$oauth_token,$oauth_token_secret);
	$session->setValue("oauth_verifier",$oauth_verifier);
	$session->setValue("social_network_name","twitter");
	$session->setValue("social_network_data",$twitter->data);
	$session->setValue("social_network_id",$twitter->social_network_id);
	
	$session->get();
	
	Redirect("../../index.php");
} else {
    Redirect("login-twitter.php");
}



?>
