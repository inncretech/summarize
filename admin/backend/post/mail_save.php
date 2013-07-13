<?php
include "../database/database.class.php";

$request 	= json_decode(file_get_contents('php://input'));

$db->mail->add($request->subject,$request->message);
?>