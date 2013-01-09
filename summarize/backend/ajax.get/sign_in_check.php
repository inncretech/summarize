<?php
require_once "../constants.php";
require_once "../database/database.class.php";
$database = new Database();
$data = $database->escape($_POST);
$info = $database->member->check_user($data);
if ($info == false){
	echo "false";	
}else{
	require_once "../session.class.php";
	$session = new Session();
	$session->sign_in($info);
	echo "true";
}
?>