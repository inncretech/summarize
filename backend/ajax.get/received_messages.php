<?php
include "../constants.php";
include "../session.class.php";

$database 		= new Database();
$session  		= new Session();
$data 			= $database->escape($_POST);
$member_data	= $session->get();

$messages 		= $database->message->getReceived($member_data['member_id']);
for ($i = 0; $i < count($messages); $i++) {
	$tmp_member = $database->member->get($messages[$i]['from_member_id']);
	$messages[$i]['from_member'] = $tmp_member;
}
echo json_encode($messages);
?>