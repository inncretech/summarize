<?php
include "../database/database.class.php";
include "../session.class.php";

$request 	= Array();
$responce 	= Array();

$responce = $db->member->getAll();

$count 	= count($responce);
for ($i = 0; $i<$count ; $i++) {
    $responce[$i]['info'] = $db->member_info->get($responce[$i]['member_id']);
}

echo json_encode($responce);


?>