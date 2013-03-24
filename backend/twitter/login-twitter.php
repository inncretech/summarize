<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";


$session = new Session();
$twitter = new Tw();

$request_data = $twitter->getLoginUrl();

$session->setValue('oauth_token',$request_data['oauth_token']);
$session->setValue('oauth_token_secret',$request_data['oauth_token_secret']);


Redirect($request_data['loginUrl']);
?>
