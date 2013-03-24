<?php



class Macys
{

	/* Class constructor */
	function Macys()
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
		
		foreach($html->find('span[class=priceSale]') as $element){ //for music
			$cost = trim(strip_tags($element->plaintext));
			break;
		}
		
		foreach($html->find('h1[id=productTitle]') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		if (empty($title)) {
			foreach($html->find('h2[id=productName]') as $element) {
			$title = $element->plaintext;	
			break;
			}
		}
		
		//general
		foreach($html->find('div[id=prdDesc]') as $element) {
		$descr .= trim(strip_tags($element->plaintext));
			break;
		}
		
		if (empty($descr)) {
			foreach($html->find('div[id=productLongDescription]') as $element) {
			$descr = $element->plaintext;	
			break;
			}
		}

		foreach($html->find('div[id=zoomViewerWrapper]') as $element) {
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
		$data['image']       = $image;
		
		
		return $data;
	}
}

?>