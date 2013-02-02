<?php
session_start();
include 'database.php';
$uid=htmlspecialchars(stripslashes(strip_tags($_SESSION['uid'])));
$ans=htmlspecialchars(stripslashes(strip_tags($_POST['ans'])));
$cat=htmlspecialchars(stripslashes(strip_tags($_POST['cat'])));
$sub=htmlspecialchars(stripslashes(strip_tags($_POST['sub'])));
$qid=htmlspecialchars(stripslashes(strip_tags($_POST['qid'])));
$pid=htmlspecialchars(stripslashes(strip_tags($_POST['pid'])));
$type=htmlspecialchars(stripslashes(strip_tags($_POST['type'])));
$data=$database->query("SELECT name FROM product WHERE idproduct='".$pid."'");
$info = mysql_fetch_array ($data);
if ($type!='on'){$type='good';}else{$type='bad';}
$database->addFeedback($cat,$sub,$type, $uid);
$database->addAnswers($qid,$pid,$uid,$ans);
$database->addPoints($_SESSION['uid'],$pid,"answer",ANSWER_POINTS);
$database->addActivity($_SESSION['uid'], $pid, "Answer", $ans, $info['name']);
?>