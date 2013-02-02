<?php
require_once "../constants.php";
require_once "../session.class.php";
require_once "../global.functions.php";

$database  	= new Database();
$data 		= $database->escape($_POST);
$data       = $database->product_feedback->getRateData($data['product_id'],$_POST['type']);
header("Content-type: text/json");
echo json_encode($data);
?>