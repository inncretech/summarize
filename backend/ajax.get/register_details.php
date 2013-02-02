<?php
include "../constants.php";
include "../database/database.class.php";
$database = new Database();
$info = $database->reference_question->getAll();
echo $info;
?>