<?php
$login = null;
if (array_key_exists('login',$_SESSION)){
	$login = $_SESSION['login'];
}
if ($login != 'twitter'){
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
			$user = null;
	  }
	}
}
if (isset($page))
if ($page!="profile.php"){
	if (array_key_exists('uid',$_SESSION)){
		$verifylogintype=$database->query("Select * from users where `uid`='".$_SESSION['uid']."' ");
		$verifylogintype=mysql_fetch_array($verifylogintype);
		$logintype=$verifylogintype['logintype'];
		if (($logintype=="twitter") && ($verifylogintype['email']==null))
		Redirect("profile.php");
	}
}
?>