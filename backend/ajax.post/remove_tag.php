<?php
include "../constants.php";
include "../database/database.class.php";
$database = new Database();
$data 	= $database->escape($_POST);
$tag_data = $database->tag->getByName($data['tag_name']);
$database->product_tag->remove($tag_data['id'],$data['product_id']);
?>