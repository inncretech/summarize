<?php
require_once "../constants.php";
require_once "../session.class.php";
require_once "../global.functions.php";

$database  	= new Database();
$data 		= $database->escape($_POST);
$database->product_feedback->changeCategory($data['old_category'],$data['new_category'],$data['product_id']);

?>