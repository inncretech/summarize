<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$database  	= new Database();
$data 		= $database->escape($_POST);
$database->product_feedback->changeCategory($data['old_category'],$data['new_category'],$data['product_id']);

?>