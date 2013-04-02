<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$database  			= new Database();	
$data 				= $database->escape($_POST);

$database->survey->remove($data['survey_id']);

?>