<?php
include "../session.class.php";
$session	= new Session();
$facebook 	= new Fb();

$photo 		= $facebook->connection->api('/me/feed/', 'POST',
										array(
										'link' => $_POST['url'],
										'name' => 'SummarizIt',
										'description'=>'Check this product from SummarizIt.',
										'message'       => $_POST['title']
										)
);
?>