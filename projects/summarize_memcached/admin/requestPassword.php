<?php
session_start();
include "../include/database.php";
if (isset($_POST['email'])){
	$data=$database->query("SELECT * FROM constants WHERE `admin_email`='".$_POST['email']."'");
	if (mysql_num_rows($data)>0) {
		$pass=md5(time());
		$_SESSION["admin_pass"]=$pass;
		$database->sendEmail($_POST["email"],"Admin password request",$pass);
		
	}else{
	
	}
}
?>