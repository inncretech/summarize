<?php
session_start();
include 'database.php';
$uid=$_SESSION['uid'];
$que=$_POST['que'];
$pid=$_POST['pid'];
$que = htmlspecialchars(stripslashes(strip_tags($que)));
$uid = htmlspecialchars(stripslashes(strip_tags($uid)));
$pid = htmlspecialchars(stripslashes(strip_tags($pid)));
$data=$database->query("SELECT name FROM product WHERE idproduct='".$pid."'");
$info = mysql_fetch_array ($data);

$database->addQuestion($pid,$uid,$que);
$database->addNotification($uid,$_SESSION['username'],$que, $pid);
$database->addActivity($uid, $pid, "Question", $que , $info['name'] );
$database->addPoints($_SESSION['uid'],$pid,"question",QUESTION_POINTS);
?>