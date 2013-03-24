<?php
include "../constants.php";
include "../session.class.php";
$database 		= new Database();
$data			= $database->escape($_GET);

$tags 	= $database->tag->getByQuery($data['query']);
$tags 	= array_slice($tags, 0, 3);

echo json_encode($tags);
?>