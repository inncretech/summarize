<?php
include "../constants.php";
include "../database/database.class.php";

$database = new Database();
$data  =  $database->escape($_POST);
$check =  $database->member->check($data);
echo $check;
?>