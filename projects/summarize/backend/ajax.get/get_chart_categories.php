<?php
require_once "../constants.php";
require_once "../session.class.php";
require_once "../global.functions.php";

$database  	= new Database();
$data 		= $database->escape($_POST);
$data       = $database->product_feedback->getCategories($data['product_id']);
header("Content-type: text/json");
echo json_encode($data);
?>