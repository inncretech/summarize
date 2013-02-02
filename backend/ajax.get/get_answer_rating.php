<?php
include "../constants.php";
include "../session.class.php";

$database  			= new Database();		
$data 				= $database->escape($_POST);

echo json_encode($database->answers->getRating($_POST['answer_id']));
?>