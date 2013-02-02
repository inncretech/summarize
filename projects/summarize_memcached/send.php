<?php
include ("database.php");
$from = $_POST['from'];
$to = $_POST['to'];
$message = $_POST['msg'];
$database->query("INSERT INTO `messages` (`from`,`to`,`message`,`date`) VALUES ('$from','$to','$message',now())");
?>