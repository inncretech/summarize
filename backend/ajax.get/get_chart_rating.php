<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$database  	= new Database();
$data 		= $database->escape($_POST);
$data       = $database->product_feedback->getRateData($data['product_id'],$_POST['type']);
header("Content-type: text/json");
echo json_encode($data);
?>