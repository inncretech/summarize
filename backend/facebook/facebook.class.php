<?php
//include "../constants.php";

/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require 'facebook.sdk.class/facebook.php';

class Fb
{
   var $connection;
   var $check = false;
   var $user;
   var $data;
   var $loginUrl;
   var $logoutUrl;
   
   /* Class constructor */
    function Fb(){
		// Create our Application instance (replace this with your appId and secret).
		$this->connection = new Facebook(array(
		  'appId'  => FB_APP_ID,
		  'secret' => FB_APP_SECRET,
		));
		// Get User ID
		$this->user = $this->connection->getUser();
		// We may or may not have this data based on whether the user is logged in.
		//
		// If we have a $user id here, it means we know the user is logged into
		// Facebook, but we don't know if the access token is valid. An access
		// token is invalid if the user logged out of Facebook.

		if ($this->user) {
		  try {
			// Proceed knowing you have a logged in user who's authenticated.
			$params = array( 'next' => 'http://' .$_SERVER['SERVER_NAME'] .'/index.php');
			
			$this->data = $this->connection->api('/me');
			$this->check = true;
			$this->logoutUrl 	= $this->connection->getLogoutUrl($params);
		  } catch (FacebookApiException $e) {
			$this->user = null;
		  }
		}else{
			if(strpos($_SERVER["REQUEST_URI"],"?") !== false){
				$params = array('redirect_uri' => 'http://' .$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"].'&facebook_sign_in=true','scope' => 'email,publish_stream');
			}else{
				$params = array('redirect_uri' => 'http://' .$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"].'?facebook_sign_in=true','scope' => 'email,publish_stream');
			}
			$this->loginUrl 	= $this->connection->getLoginUrl($params);
			
		}
		
		/*
		public function logout()
		{
			$params = array( 'next' => 'http://www.' + $host + '/index.php/authentication_controller/signout');
			return $this->connection->getLogoutUrl($params));
		}
		*/
		
	}
}

/* Example of use

$facebook = new Fb();

if ($facebook->check) {
  $logoutUrl = $facebook->connection->getLogoutUrl();
  echo "<a href='".$logoutUrl."'>Logout</a>";
} else {
  $loginUrl = $facebook->connection->getLoginUrl();
  echo "<a href='".$loginUrl."'>Login</a>";
}
print_r($facebook->data);

*/

?>