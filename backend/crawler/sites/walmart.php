<?php



class Walmart
{

	/* Class constructor */
	function Walmart()
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
		
		foreach($html->find('span[class=bigPriceText1]') as $element){ //for music
			$cost = trim(strip_tags($element->plaintext));
			break;
		}
	
	
		foreach($html->find('h1[class=productTitle]') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		if(empty($title)){
			foreach($html->find('td[class=mainheader]') as $element) //for music
				$title = trim(strip_tags($element->plaintext));
		}
		
		//general
		foreach($html->find('div[id=prodInfoSpaceBottom]') as $element) 
		$descr .= trim(strip_tags($element->plaintext));
		
		if(empty($descr)){
			foreach($html->find('td[class=generaltext]') as $element) 
			$descr .= trim(strip_tags($element->plaintext));
		}
		

			foreach($html->find('img[id=mainImage]') as $element) {
				$image = $element->src;	
			}
	
		$data['title']		 = $title;
		$data['description'] = $descr;$data['cost']        = $cost;
		$data['image']       = $image;
		
		
		return $data;
	}
}

?>