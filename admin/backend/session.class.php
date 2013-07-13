<?php

class Session
{
	var $key 		= "member_id";
	
	/* Class constructor */
	function Session($path = "/")
	{	
		if (session_id()==""){
			ini_set('session.use_cookies', true);
			session_name("WebsiteID");
			ini_set('session.use_trans_sid',1);
			session_start();
		}
	}
	
	function login($data){
		foreach ($data as $key=>$value){
			$_SESSION[$key] = $value;
		}
	}
	function getValue($key){
		return $_SESSION[$key];
	}
	
	function setValue($key,$value){
		$_SESSION[$key] = $value;
	}
	
	function unsetValue($key){
		unset($_SESSION[$key]);
	}
	
	function get(){
		return $_SESSION;
	}
	function refresh(){
		session_destroy();
		if (session_id()==""){
			ini_set('session.use_cookies', true);
			session_name("WebsiteID");
			ini_set('session.use_trans_sid',1);
			session_start();
		}
	}
	
	function destroy(){
		session_destroy();
	}
	
	function checkValue($key){
		return (isset($_SESSION[$key]));
	}
	
	function check(){
		return (isset($_SESSION[$this->key]));
	}
}

$session = new Session();
?>