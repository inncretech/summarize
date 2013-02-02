<?php
session_start();
include "../include/db_constants.php";
include "../include/database.php";
if ((isset($_POST['email']))&&(isset($_POST['password']))){
	$data=$database->query("SELECT * FROM constants WHERE `admin_email`='".$_POST['email']."'");
	if (mysql_num_rows($data)>0) {
		if ($_POST['password']==$_SESSION["admin_pass"]){unset($_SESSION["admin_pass"]);$_SESSION['admin_login']=true;$_SESSION['admin_email']=$_POST['email'];}
	}else{
	
	}
}
?>