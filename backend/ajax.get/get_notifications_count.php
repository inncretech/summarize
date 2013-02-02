<?php
include "../session.class.php";
include "../global.functions.php";

$database   			= new database();
$session   				= new Session();
$user_data			    = $session->get();

$count	= $database->notifications->getCount($user_data['member_id']);

echo $count;
?>