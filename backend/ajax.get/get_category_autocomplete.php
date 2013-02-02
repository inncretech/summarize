<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$database  	= new Database();
$data 		= $database->escape($_POST);
$data       = $database->product_feedback->getAutoSearchData($data['query'],$data['product_id']);
header("Content-type: text/json");
echo json_encode($data);
?>