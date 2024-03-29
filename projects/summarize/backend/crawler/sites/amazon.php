<?php
require_once 'simple_html_dom.php';


class Amazon
{

	/* Class constructor */
	function Amazon()
	{
		
	}
	
	function getData($url){
	
		$data = Array();
		$html = file_get_html($url);
	
		foreach($html->find('span[id=btAsinTitle]') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		if(empty($title)){
			foreach($html->find('div[id=prod-details] h1') as $element) //for movies
			$title = trim(strip_tags($element->plaintext));
		}
		$title = str_replace('[Download]','', $title);
		if(strlen($title)>40) $data['title'] = substr($title, 0, 40); else $data['title'] = $title;
	
	
	
	
		//general
		foreach($html->find('div[class=bucket] div[id=kindle-say-hello]') as $element) 
		$descr .= trim(strip_tags($element->plaintext));
		
		// for movie-amazon
		if(empty($descr)){
			foreach($html->find('div[class=prod-synopsis]') as $element) 
			$descr = trim(strip_tags($element->plaintext));
			//take rest of details
			if(!empty($descr)){
				foreach($html->find('div[class=prod-other]') as $element) 
				$descr .= trim(strip_tags($element->plaintext));
			}
		}
		//kindle template 2,3 & accessories
		if(empty($descr)){
			foreach($html->find('div[class=bucket] div[id=kindle-say-hello]') as $element) 
			$descr .= trim(strip_tags($element->plaintext));
		}
		//kindle template 1
		if(empty($descr)){
			foreach($html->find('div[id=kindle-feature-bullets-atf]') as $element) 
			$descr = trim(strip_tags($element->plaintext));
		}
		//for music
		if(empty($descr)){
			foreach($html->find('div[class=kindle-feature] div[class=sub-headline]') as $element) 
			$descr .= trim(strip_tags($element->plaintext));
		}
		// books
		if(empty($descr)){
			foreach($html->find('div[class=content] div[id=outer_postBodyPS] div[id=postBodyPS]') as $element) 
			$descr = trim(strip_tags($element->plaintext));
		}
		//general case 2
		if(empty ($descr)){
			foreach($html->find('div[class=productDescriptionWrapper]') as $element) 
			$descr .= trim(strip_tags($element->plaintext));
		}
		//general case 1 - last resort
		if(empty($descr)){
			foreach($html->find('td[class=bucket] div[class=content]') as $element) 
		    $descr = trim(strip_tags($element->plaintext));
		}
		$descr = preg_replace("/&#?[a-z0-9]+;/i","",preg_replace('/ +/', ' ', preg_replace('/&#8226;/',' ',preg_replace('/&nbsp/',' ',preg_replace('/\(view larger\)\./','',$descr)))));
		
		$data['description'] = $descr;
		
		foreach($html->find('img[id=prodImage]') as $element) {
			$data['image'] = $element->src;
		}
		
		return $data;
	}
}

?>