<?php
include "../crawler/crawler.class.php";

$url = $_POST['url'];

$crawler 		= new crawler();
$domain 		= $crawler->getDomain($url);
$ok 			= false;
switch ($domain){
	case "amazon":
		$ok = true;
	break;
	case "bestbuy":
		$ok = true;
	break;
	case "walmart":
		$ok = true;
	break;
	case "staples":
		$ok = true;
	break;
	case "newegg":
		$ok = true;
	break;
	case "dell":
		$ok = true;
	break;
	case "ebay":
		$ok = true;
	break;
	case "sears":
		$ok = true;
	break;
	case "sony":
		$ok = true;
	break;
	case "panasonic":
		$ok = true;
	break;
	case "macys":
		$ok = true;
	break;
	case "toysrus":
		$ok = true;
	break;
	case "officedepot":
		$ok = true;
	break;
}

if ($ok){
	echo "true";
}else{
	echo "false";
}
?>