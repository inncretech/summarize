<?php 
include "../session.class.php";

$database 	= new Database();
$session 	= new Session();

$member_data = $session->get();

$data = $database->escape($_POST);
$database->crawl_site->add($data['url'],$member_data['member_id']);
?>