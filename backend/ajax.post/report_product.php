<?php
include "../constants.php";
include "../session.class.php";

$database  				= new Database();
$session				= new Session();
$member_data 			= $session->get();			
$data 					= $database->escape($_POST);
$data['member_id']		= $member_data['member_id'];

$report_id 				= $database->report_product->add($data);

?>