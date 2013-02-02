<?php
require_once "../constants.php";
require_once "../database/database.class.php";
$database = new Database();
$data = $database->escape($_POST);
$info = $database->product_feedback->getById($data['feedback_id']);
echo json_encode($info);
?>