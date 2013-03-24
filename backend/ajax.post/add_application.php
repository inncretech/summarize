<?php
include "../constants.php";
include "../session.class.php";

$database  						= new Database();
$session						= new Session();
$member_data 					= $session->get();			
$data 							= $database->escape($_POST);
$data['application_request_id']	= md5(time());
$data['created_by']				= $member_data['member_id'];
$info							= $database->application_id->add($data['created_by'],$data['application_request_id'],$data['site_name']);
$data['application_id']			= $info['application_id'];
$database->application_info->add($data);

echo json_encode($data['application_request_id']);
?>