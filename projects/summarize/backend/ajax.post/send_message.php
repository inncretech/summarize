<?php
require_once "../constants.php";
require_once "../session.class.php";

$database 					= new Database();
$session  					= new Session();
$data 						= $database->escape($_POST);
$member_data				= $session->get();
$data['from_member_id']		= $member_data['member_id'];
$to_member_data 			= $database->member->getByLogin($data['to_member_name']);
$data['to_member_id']		= $to_member_data['member_id'];
$database->message->add($data);

?>