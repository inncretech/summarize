<?php
require_once 'simple_html_dom.php';
$parse = parse_url($_POST['url']);
if ($parse['host']=='www.amazon.com'){Amazon();}
if ($parse['host']=='www.groupon.com' || $parse['host']=='www.groupon.ro' || $parse['host']=='oferte-travel.groupon.ro'){Groupon();}

function Amazon(){
	$html = file_get_html($_POST['url']);
	if (isset($_POST['title'])) {
		foreach($html->find('span[id=btAsinTitle]') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		if(empty($title)){
			foreach($html->find('div[id=prod-details] h1') as $element) //for movies
			$title = trim(strip_tags($element->plaintext));
		}
		$title = str_replace('[Download]','', $title);
		if(strlen($title)>40) echo substr($title, 0, 40); else echo $title;
	
	}
	
	if (isset($_POST['description'])) {
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
		
		echo $descr;
	}
	
}

function Groupon(){
	$html = file_get_html($_POST['url']);
	if (isset($_POST['title'])) {
		foreach($html->find('div[class=deal_title]') as $element) {
		$title = preg_replace('/&#8211;/',' ',trim(strip_tags($element->plaintext)));
		}
	if (empty($title)) {
		foreach($html->find('div[id=contentDealTitle]') as $element)
		$title = preg_replace('/&#8211;/',' ',trim(strip_tags($element->plaintext)));
		}
	if (empty($title)) {
		foreach($html->find('h1[class=title]') as $element)
		$title = preg_replace('/&#8211;/',' ',trim(strip_tags($element->plaintext)));
	}
	if (empty($title)) {
		foreach($html->find('div[class=title_container]') as $element)
		$title = preg_replace('/&#8211;/',' ',trim(strip_tags($element->plaintext)));
	}
	
	if(strlen($title)>40) echo substr($title, 0, 40); else echo $title;
	}

	if (isset($_POST['description'])) {
		foreach($html->find('div[class=pitch_content]') as $element)
		$descr = str_replace( '"', "'",trim(strip_tags($element->plaintext)));
	
	if(empty($descr)) {
		foreach($html->find('div[class=contentBoxNormalLeft]') as $element) 
		$descr = str_replace( '"', "'",trim(strip_tags($element->plaintext)));
		}
		
	if(empty($descr)) {
		foreach($html->find('div[id=tab-highlights]') as $element) 
		$descr = str_replace( '"', "'",trim(strip_tags($element->plaintext)));
	}
	$descr = preg_replace('/\s+/', ' ', $descr);
	echo $descr;
	}
	if (isset($_POST['photoimg'])) foreach($html->find('div[class=photos]') as $element){
		$img_src = $element->src;
		echo $img_src;
	}
}
?>
