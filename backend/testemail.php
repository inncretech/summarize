<?php
include "constants.php";
include "session.class.php";
include "email.system/amazon.email.php";
include "global.functions.php";
include "email.system/amazon.email.php";
$ses = new AmazonEmail();
$subject = "SummarizIt.com Registration";
//$message = "Welcome to SummarizIt.com here are you credentials:\n Username: ".$data['login']."\n Password: ".$data['password'] ;
$ses->send("vishal@inncretech.com",$subject,"test php e-mail");
echo "sent";
Redirect(SITE_ROOT."/index.php?sign_out=true");
?>
