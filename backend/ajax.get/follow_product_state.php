<?php
include "../constants.php";
include "../session.class.php";

$database 		= new Database();
$session  		= new Session();
$data 			= $database->escape($_POST);
$member_data	= $session->get();

if ($database->product_follow->check($member_data['member_id'],$data['product_id'])) echo "true"; else echo "false";
?>