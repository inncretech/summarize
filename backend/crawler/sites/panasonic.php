<?php



class Panasonic
{

	/* Class constructor */
	function Panasonic()
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
		
		foreach($html->find('td[class=price lgprice]') as $element){ //for music
			$cost = trim(strip_tags($element->plaintext));
			break;
		}
		
		foreach($html->find('div[id=productInfo]') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		if (empty($title)) {
			foreach($html->find('h2[id=productName]') as $element) {
			$title = $element->plaintext;	
			break;
			}
		}
		
		//general
		foreach($html->find('div[id=flContent]') as $element) {
		$descr .= trim(strip_tags($element->plaintext));
			break;
		}
		
		if (empty($descr)) {
			foreach($html->find('div[id=productLongDescription]') as $element) {
			$descr = $element->plaintext;	
			break;
			}
		}

		foreach($html->find('div[id=productImages] img') as $element) {
			$image = $element->src;	
			break;
		}
		if (empty($image)) {
			foreach($html->find('ul[id=featureCards] img') as $element) {
			$image = $element->src;	
			break;
			}
		}
		
		if (empty($image)) {
			foreach($html->find('div[id=productDetailHeroImage] img') as $element) {
			$image = $element->src;	
			break;
			}
		}
		$data['title']		 = $title;
		$data['description'] = $descr;$data['cost']        = $cost;
		if (!empty($image)) 	$data['image']       = "http://cdn.panasonic.com".$image;
		
		
		return $data;
	}
}

?>