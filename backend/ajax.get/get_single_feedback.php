<?php
include "../constants.php";
include "../database/database.class.php";
$database = new Database();
$data = $database->escape($_POST);
$info = $database->product_feedback->getById($data['feedback_id']);
echo json_encode($info);
?>