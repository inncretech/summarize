<?php
include "backend/constants.php";
include "backend/database/database.class.php";

$database 	= new Database();
$data 		= $database->query("SELECT * FROM `product`");
while ($info = mysql_fetch_array($data)){
	$word = count(explode(" ",$info['title']));
	$seo   = substr($info['title'], 0, strrpos($info['title'], " "));
	if ($word>4) echo $info['title']." ||| ".$seo." <br>";
	//$database->query("UPDATE `product` SET `title`='".$seo."' WHERE `product_id`=".$info['product_id']."");

}
?>