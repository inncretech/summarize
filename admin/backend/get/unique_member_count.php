<?php
include "../database/database.class.php";
include "../session.class.php";

$responce 	= Array();

$responce = $db->product_feedback->getUniqueMemberCount();

echo json_encode($responce);


?>