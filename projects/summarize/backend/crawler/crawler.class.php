<?php

require_once "sites/amazon.php";

class crawler
{
	
	var $amazon;
	/* Class constructor */
	function crawler()
	{
		$this->amazon = new Amazon();
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