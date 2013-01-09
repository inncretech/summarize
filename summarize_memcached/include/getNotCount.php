<?php 
session_start();
include "database.php";
if (isset($_SESSION['uid'])){
$count=0;
$follows=$database->query("Select * from notifications_follow where uid='".$_SESSION['uid']."'");
$q="";
while ($info=mysql_fetch_array($follows)){
		$q=$q."(`idproduct`='".$info['product']."' and `date`>'".$info['date']."') OR ";
}
$follows=$database->query("select * from notifications where $q 1=2 ORDER BY `date` DESC;");
if (mysql_num_rows($follows)<1){
	$count=0;
} else {
	$count=mysql_num_rows($follows);
}
echo $count;				
}
?>