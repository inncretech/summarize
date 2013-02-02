<?php
include "../constants.php";
include "../session.class.php";
$database 		= new Database();
$session 		= new Session();

$data 			= $session->getCompareValue();
$info			= Array();

foreach ($data as $key=>$item){
	if($item['check']) $info[$key]=$item;
}

echo json_encode($info);
?>