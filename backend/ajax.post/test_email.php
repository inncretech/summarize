<?php
include "../constants.php";
include "../email.system/amazon.email.php";
include '../email.system/mailchimp/MCAPI.class.php';

$key = '666da1a86e6ef0b8b141c0f59af35732-us6';
$api = new MCAPI($key);



$send_this_email = 'iza14_2006@yahoo.com';
$mergeVars = Array();


$list_id = "6521b58e64";

// Send the form content to MailChimp List without double opt-in
$retval = $api->listSubscribe($list_id, $send_this_email, $mergeVars, 'html', false);








/*
$ses = new AmazonEmail();
$subject = "SummarizIt.com Registration";
$file = file_get_contents(SITE_ROOT.'/backend/email.system/template/index.html', true);
$message = $file;
$ses->send('pietroiu.alexandru@gmail.com',$subject,$message);
*/
?>