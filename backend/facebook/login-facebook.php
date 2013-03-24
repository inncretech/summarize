<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$session 	= new Session();
$facebook 	= new Fb();


if ($facebook->check){
	$session->setValue("social_network_name","facebook");
	$session->setValue("social_network_data",$facebook->data);
	$session->setValue("social_network_id",$facebook->social_network_id);
	
	
	
	Redirect("../../index.php");
}else{
	$loginUrl 	= $facebook->getLoginUrl();
	Redirect($loginUrl);
}
?>
