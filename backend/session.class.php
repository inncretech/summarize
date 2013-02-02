<?php
require_once "constants.php";
include "database/database.class.php";
include "memcached/memcached.class.php";
include "solr/solr.class.php";
include "facebook/facebook.class.php";
include "twitter/twitter.class.php";

class Session
{
	var $key = "member_id";
	/* Class constructor */
	function Session($get = null,$url = null)
	{	
		if ($get!=null){
			if (isset($get['sign_out'])){
				$this->refresh();
				if ($url!=null) Redirect($url);
				Redirect ("index.php");
			}
		}else{
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
		session_start();
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
	
	function check(){
		return (isset($_SESSION[$this->key]));
	}
}
?>