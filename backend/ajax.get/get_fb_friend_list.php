<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$session  	= new Session();
$database  	= new Database();
$data		= $database->escape($_GET);
$member_data = $session->get();
$friends 	 = $database->facebook_friend->get($member_data['member_id'],$data['query']);

echo json_encode($friends);
?>