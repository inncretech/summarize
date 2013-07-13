<?php
include "../database/database.class.php";
include "../session.class.php";

$responce 	= Array();

$responce = $db->tag->getCount();

echo json_encode($responce);


?>