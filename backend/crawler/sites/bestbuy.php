<?php



class Bestbuy
{

	/* Class constructor */
	function Bestbuy()
	{
		
	}
	
	function getData($url){
	
		$data 	= Array();
		$title 	= null;
		$descr 	= null;
		$image 	= null;$cost 	= null;
		
		$opts = array('http' =>
						  array(
							'user_agent' => 'MyBot/1.0 (http://www.mysite.com/)'
						  )
						);
		$context = stream_context_create($opts);
		
		$html 	= file_get_html($url, FALSE, $context);
		
		foreach($html->find('div[class=item-price]') as $element){ //for music
			$cost = trim(strip_tags($element->plaintext));
			break;
		}
		
		foreach($html->find('div[id=sku-title] h1') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		if (empty($title)){
			foreach($html->find('div[id=productsummary] h1') as $element) //for music
			$title = trim(strip_tags($element->plaintext));
		}
		
		//general
		foreach($html->find('div[id=long-description]') as $element) 
		$descr .= trim(strip_tags($element->plaintext));
		
		if (empty($descr)){
			foreach($html->find('div[class=csc-medium-column csc-last-column] p') as $element) //for music
			$descr = trim(strip_tags($element->plaintext));
		}
		
		foreach($html->find('div[class=image-gallery-main] div[class=image-gallery-main-slide] a img') as $element) {
			$image = $element->src;
		}
		
		if (empty($image)){
			foreach($html->find('div[class=csc-small-column] a img') as $element) {
			$image = $element->src;
			}	
		}
		$data['title']		 = $title;
		$data['description'] = $descr;$data['cost']        = $cost;
		$data['image']       = $image;
		
		
		return $data;
	}
}

?>