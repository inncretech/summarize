<?php
require "facebook.php"; 
$facebook = new Facebook(array( 
  'appId'  => FB_APP_ID,
  'secret' => FB_APP_SECRET,
));
// See if there is a user from a cookie
$user = $facebook->getUser();
$loginUrl = $facebook->getLoginUrl(array('scope' => 'email,publish_stream'));
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
?>