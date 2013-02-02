<?php
include "../include/database.php";
$from = $_POST['from'];
$to = $_POST['to'];
$message = $_POST['msg'];
$users = explode(',',$to);
foreach ($users as &$user) 
{
$database->query("INSERT INTO `message` (`from`,`to`,`message`,`date`) VALUES ('$from','$user','$message',now())");
}
?>