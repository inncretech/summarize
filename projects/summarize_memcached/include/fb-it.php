<?php
session_start();
if ($_SESSION['twitter']!="1"){
	require "facebook.php"; 
	$facebook = new Facebook(array( 
	  'appId'  => '468472069854196',
	  'secret' => '9bdf1e48ed7845fff3c5c393a66192db',
	));
	// See if there is a user from a cookie
	$user = $facebook->getUser();
	$loginUrl = $facebook->getLoginUrl(array('scope' => 'email'));
	$_SESSION['logouturl']=$facebook->getLogoutUrl();

	if ($user) {
	  try {
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
		$_SESSION['email']=$user_profile['email'];
		$_SESSION['username']=$user_profile['username'];
	  } catch (FacebookApiException $e) {
		//   echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
		$user = null;
	  }
	}
}
$url=$_POST['url'];
$name=$_POST['name'];
$photo = $facebook->api('/me/feed/', 'POST',
					array(
					'link' => $url,
					'name' => 'Summarize',
					'description'=>'Check this product from Summarize!',
					'message'       => $name
					)
					);
?>