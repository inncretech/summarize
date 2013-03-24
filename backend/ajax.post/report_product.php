<?php
include "../constants.php";
include "../session.class.php";
include "../email.system/amazon.email.php";

$database  				= new Database();
$session				= new Session();
$member_data 			= $session->get();			
$data 					= $database->escape($_POST);
$data['member_id']		= $member_data['member_id'];

$report_id 				= $database->report_product->add($data);


$ses = new AmazonEmail();
$subject = "SummarizIt.com Product Reported";
$message = SITE_ROOT."/product/".$data["product_id"] ;
$ses->send(AWS_SAS_EMAIL,$subject,$message);
?>