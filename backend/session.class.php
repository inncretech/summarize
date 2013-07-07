<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: content-type");
require_once "constants.php";
include "database/database.class.php";
include "memcached/memcached.class.php";
include "solr/solr.class.php";
include "facebook/facebook.class.php";
include "twitter/twitter.class.php";

class Session
{
	var $key 		= "member_id";
	var $admin_key 	= "permission_level";
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
	
	function sign_in($data){
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
	
	function unsetValue($key,$value){
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
	function getCompareValue(){
		return $_SESSION['compare_list'];
	}
	function setCompareValue($key,$value){
		$_SESSION['compare_list'][$key] = $value;
	}
	
	function admin(){
		return ($_SESSION[$this->admin_key]=="1");
	}
	function check(){
		return (isset($_SESSION[$this->key]));
	}
}
?>