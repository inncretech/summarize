<?php
include "../database/database.class.php";
include "../session.class.php";

$request 	= Array();
$responce 	= Array();

$responce = $db->mail->getAll();

echo json_encode($responce);


?>