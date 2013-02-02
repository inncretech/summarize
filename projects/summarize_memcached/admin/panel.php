<?php
session_start();
include "../include/database.php";

if (isset($_SESSION['admin_login'])){
	if (isset($_POST['update'])){
		$str="UPDATE constants SET ";
		foreach ($_POST as $key => $value){
			if ($key!="update"){
				$str .= "`".$key."`='".$value."' ,";
				if ($key!="admin_email"){
					$constants.="define('".$key."', '".$value."');\n";
				}
			}
		}
		$str = substr_replace($str ,"",-1);
		$str .="WHERE `admin_email`='".$_SESSION['admin_email']."'";
		$database->query($str);
	}
	echo "<form action='index.php' method='POST'><input name='logout' type='submit' value='Log out'></form>";
	$data=$database->query("SELECT * FROM constants WHERE `admin_email`='".$_SESSION['admin_email']."'");
	$info=mysql_fetch_array($data);
	echo "<form action='panel.php' method='POST'><table>";
	foreach ($info as $key => $value){
		if ((!is_numeric($key))&&($key!="id")){
			echo "<tr><td>".$key."</td><td><input type='text' name='".$key."' value='".$value."' style='width:600px;'></td></tr>";
		}
	}
	echo "<tr><td></td><td><input type='submit' name='update' value='Update'></td></tr>";
	echo "</table><form>";
}else{
Redirect("index.php");
}
?>