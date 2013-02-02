<?php
require_once "simple_html_dom.php";

require_once "sites/amazon.php";
require_once "sites/bestbuy.php";
require_once "sites/walmart.php";
require_once "sites/staples.php";
require_once "sites/newegg.php";
require_once "sites/dell.php";
require_once "sites/ebay.php";
require_once "sites/sears.php";
require_once "sites/sony.php";
require_once "sites/panasonic.php";
require_once "sites/macys.php";
require_once "sites/toysrus.php";
require_once "sites/officedepot.php";

class crawler
{
	
	var $amazon;
	var $bestbuy;
	var $walmart;
	var $staples;
	var $newegg;
	var $dell;
	var $ebay;
	var $sears;
	var $sony;
	var $panasonic;
	var $macys;
	var $officedepot;
	
	/* Class constructor */
	function crawler()
	{
		$this->amazon 			= new Amazon();
		$this->bestbuy 			= new Bestbuy();
		$this->walmart 			= new Walmart();
		$this->staples 			= new Staples();
		$this->newegg 			= new Newegg();
		$this->dell 			= new Dell();
		$this->ebay 			= new Ebay();
		$this->sears 			= new Sears();
		$this->sony 			= new Sony();
		$this->panasonic 		= new Panasonic();
		$this->macys 			= new Macys();
		$this->toysrus 			= new Toysrus();
		$this->officedepot 		= new Officedepot();
	}
	
	function getDomain($url){

    $parts_array = explode ( '.', $url ); 
	$total_parts = count($parts_array);
    $last_part = $parts_array[$total_parts]; 

    $domain = $parts_array[1];
	
    return $domain; 
	} 

}
?>