<?php
include "../include/database.php";
$query=$database->query("SELECT * FROM message WHERE `to`='".$_POST['user']."' ORDER BY date DESC LIMIT ".$_POST['limit'].",10 ;");
echo "<table><tr><th>From</th><th>Message</th><th>Date</th></tr><tr>";
while ($info=mysql_fetch_array($query)){
	echo "<tr style='border-bottom:2px solid white;background-color:#D8DCE2;margin-bottom:5px;color:#555;font-weight:bold;'><td valign='top'>";
	echo $info['from'];
	echo "</td><td style='width:400px;'>";
	echo $info['message'];
	echo "</td><td valign='top'>";
	echo $info['date'];
	echo "</td></tr>";
}
echo "</table><div style='margin-top:5px;'><a href='#' onclick='backRecived();return false;' style='margin-right:5px;' id='move-btn'>Back</a><a href='#' onclick='nextRecived();return false;' id='move-btn'>Next</a></div>";
?>