<?php
include "../constants.php";
include "../session.class.php";
$database 		= new Database();
$data			= $database->escape($_GET);

$value 	= $database->product_feedback->getCateogiresByQueryAndProduct($data['query']);
$value  = array_unique($value);
$value 	= array_slice($value, 0, 3);

echo json_encode($value);
?>