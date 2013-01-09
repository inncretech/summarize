<?php
session_start();
include 'database.php';
$qid=$_POST['qid'];
$data = $database->query("SELECT * FROM `answers` WHERE `qid` = '$qid'");
$answers = array();
$aux = 0;
while ($info = mysql_fetch_array($data)){
$user_data = $database->query("SELECT * FROM `users` WHERE `uid` = '".$info['uid']."'");
$user_info = mysql_fetch_array($user_data);
$answers[$aux]['user'] = $user_info['fname']." ".$user_info['lname'];
$answers[$aux]['uid'] = $info['uid'];
$answers[$aux]['ans'] = $info['answer'];
$answers[$aux]['date'] = $info['date'];
$aux = $aux+1;
}
echo json_encode($answers);
?>