<?php
require_once "../constants.php";
require_once "../database/database.class.php";
$database = new Database();
$info = $database->reference_question->getAll();
echo $info;
?>