<?php
require_once "../constants.php";
require_once "../database/database.class.php";
$database = new Database();
$data 	= $database->escape($_POST);
$tag_data = $database->tag->getByName($data['tag_name']);
$database->product_tag->remove($tag_data['id'],$data['product_id']);
?>