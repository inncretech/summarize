<?php
session_start();
include 'database.php';
$pid=$_POST['pid'];
$data = $database->query("SELECT * FROM `questions` WHERE `idproduct` = '$pid'");
$questions = array();
$aux = 0;
while ($info = mysql_fetch_array($data)){
$user_data = $database->query("SELECT * FROM `users` WHERE `uid` = '".$info['uid']."'");
$user_info = mysql_fetch_array($user_data);
$questions[$aux]['user'] = $user_info['fname']." ".$user_info['lname'];
$questions[$aux]['uid'] = $info['uid'];
$questions[$aux]['que'] = $info['question'];
$questions[$aux]['qid'] = $info['id'];
$aux = $aux+1;
}
echo json_encode($questions);
?>