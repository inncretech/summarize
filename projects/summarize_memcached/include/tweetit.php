<?php
$consumerKey    = 'HnpNGDQb73vpd7UhFyv57Q';
$consumerSecret = 'j0D5sON1WoaAXvaiLPTAU39i6xaFk7i07u8cinZRFY';
$oAuthToken     = $_POST['atk'];
$oAuthSecret    = $_POST['atksecret'];
$statusMessage="Check this product from Summarize! ".$_POST['url'];


require_once('twitteroauth.php');
// twitteroauth.php points to OAuth.php
// all files are in the same dir
// create a new instance
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
$tweet->post('statuses/update', array('status' => $statusMessage));
?>