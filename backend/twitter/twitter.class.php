<?php
include "twitter.sdk.class/twitteroauth.php";

class Tw
{
	var $connection;
	var $check = false;
	var $data;
	var $social_network_id;
	
	/* Class constructor */
	function Tw()
	{
		
	}
	
	function getUserData($oauth_verifier,$oauth_token,$oauth_token_secret){
		$this->connection 	= new TwitterOAuth(TW_APP_ID, TW_APP_SECRET, $oauth_token, $oauth_token_secret);
		
		$_SESSION['access_token'] = $this->connection->getAccessToken($oauth_verifier);
		// Let's get the user's info
		$this->data 				= objectToArray($this->connection->get('account/verify_credentials'));
		$this->social_network_id 	= $this->data["id"];
	}
	
	function getLoginUrl(){
			$this->connection 	= new TwitterOAuth(TW_APP_ID, TW_APP_SECRET);
			$request_data 		= $this->connection->getRequestToken();
			
			$_SESSION['oauth_token'] = $request_data['oauth_token'];
			$_SESSION['oauth_token_secret'] = $request_data['oauth_token_secret'];
			
			if ($this->connection->http_code == 200){
				$request_data['loginUrl'] = $this->connection->getAuthorizeURL($request_data['oauth_token']);		
			}
			
			return $request_data;
		}
	
}
?>