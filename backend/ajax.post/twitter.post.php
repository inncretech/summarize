<?php
include "../session.class.php";
include "../global.functions.php";
$session 	= new Session();
$twitter 	= new Tw();

$access_token = $session->getValue('access_token');
$twitter->connection = new TwitterOAuth(TW_APP_ID, TW_APP_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$photo 		= $twitter->connection->post('statuses/update', array('status' => $_POST['title']." ".$_POST['url']));

?>