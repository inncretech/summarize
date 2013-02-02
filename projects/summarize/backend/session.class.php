<?php
require_once "constants.php";
require_once "database/database.class.php";
require_once "memcached/memcached.class.php";
require_once "solr/solr.class.php";
require_once "facebook/facebook.class.php";
require_once "twitter/twitter.class.php";

class Session
{
	var $key = "member_id";
	/* Class constructor */
	function Session()
	{
		session_start();
	}
	
	function sign_in($data){
		foreach ($data as $key=>$value){
			$_SESSION[$key] = $value;
		}
	}
	
	function get(){
		return $_SESSION;
	}
	
	function destroy(){
		session_destroy();
	}
	
	function check(){
		return (isset($_SESSION[$this->key]));
	}
}
?>