<?php
include "../constants.php";
include "../session.class.php";
$database 		= new Database();
$session 		= new Session();

$data 				= $database->escape($_POST);
$info 				= $session->getCompareValue();
$info['check'] 		= false;
$session->setCompareValue($data['title'],$info);
?>