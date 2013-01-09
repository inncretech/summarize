<?php
require_once "../constants.php";
require_once "../database/database.class.php";
require_once "../global.functions.php";
$database = new Database();

$data = $database->escape($_POST);
$data['member_id'] = $database->member->add($data);
$created = $database->member_info->add($data);
Redirect("../../");
?>