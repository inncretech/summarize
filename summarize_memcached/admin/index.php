<?php
session_start();
include "../include/database.php";
if (isset($_POST["logout"])){unset($_SESSION["admin_login"]);unset($_SESSION["admin_pass"]);unset($_SESSION["admin_email"]);}
if (isset($_SESSION["admin_login"])){Redirect("panel.php");}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script src="js/functions.js"></script>
</head>
<body>
	<table>
	<tr>
		<td colspan="2">
			<input id="email" name="email" style="padding:3px;" type="text" placeholder="Admin email...">
		</td>
	<tr>
		<td colspan="2">
			<input id="password" name="password" style="padding:3px;" type="text">
		<td>
	</tr>
	<tr>
		<td>
			<input id="request" onclick="requestPassword();" name='request' type="submit" value="Request Password">
		</td>
		<td>
			<input id="login" onclick="login();" name='login' type="submit" value="Log In">
		</td>
	</tr>
</body>
</html>