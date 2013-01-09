<?php
include 'database.php';
$user = $_POST['u'];
$tag = $_POST['t'];
$data = $database->query("SELECT * FROM `product` WHERE `userID` = '$user' AND `tags` LIKE '%$tag%'");
$product = array();
$aux=0;
while ($info = mysql_fetch_array($data)){
	$product[$aux]['product'] = $info;
	$feedCatData = $database->query("SELECT DISTINCT(category) FROM `feedback` WHERE `uid` = '$user' AND `idproduct`='".$info['idproduct']."'");
	while ($feedCatInfo = mysql_fetch_array($feedCatData)){
		$feedData = $database->query("SELECT * FROM `feedback` WHERE `uid` = '$user' AND `idproduct`='".$info['idproduct']."' AND `category`='".$feedCatInfo[0]."'");
		$fcount = 0;
		while ($feedInfo = mysql_fetch_array($feedData)){
			$product[$aux]['feedback'][$fcount] = $feedInfo;
			$fcount += 1;
		}
	}
	$aux += 1;
}
echo json_encode($product);
?>