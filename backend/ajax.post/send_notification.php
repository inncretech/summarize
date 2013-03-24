<?php
include "../constants.php";
include "../session.class.php";

$database 		= new Database();
$session  		= new Session();
$data 			= $database->escape($_POST);
$member_data	= $session->get();
$followers		= $database->product_follow->getFollowers($data['product_id']);
$product 		= $database->product->get($data['product_id']);

foreach ($followers as $following){
	$database->notifications->add($following['member_id'],$member_data['member_id'],$member_data['public_id'],$data['type'],$data['comment'],$data['product_id'],$product['public_id'],$product['title']);
}

?>