<?php
require_once "../constants.php";
require_once "../session.class.php";

$database 		= new Database();
$data 			= $database->escape($_POST);

$database->notifications->hide($data['id']);
?>