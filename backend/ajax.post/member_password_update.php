<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$database  		= new Database();
$session    	= new Session();
$member_data 	= $session->get();
$data 			= $database->escape($_POST);
$database->member->updatePassword($data,$member_data["member_id"]);

?>