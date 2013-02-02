<?php
include "../constants.php";
include "../session.class.php";

$database 		= new Database();
$data 			= $database->escape($_POST);

$database->notifications->hide($data['id']);
?>