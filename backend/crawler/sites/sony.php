<?php



class Sony
{

	/* Class constructor */
	function Sony()
	{
		
	}
	
	function getData($url){
	
		$data 	= Array();
		$title 	= null;
		$descr 	= null;
		$image 	= null;
		$opts = array('http' =>
						  array(
							'user_agent' => 'MyBot/1.0 (http://www.mysite.com/)'
						  )
						);
		$context = stream_context_create($opts);
		
		$html 	= file_get_html($url, FALSE, $context);
		
	
		foreach($html->find('div[class=info] h1') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		if (empty($title)) {
			foreach($html->find('h2[id=productName]') as $element) {
			$title = $element->plaintext;	
			break;
			}
		}
		
		//general
		foreach($html->find('p[class=desc]') as $element) {
		$descr .= trim(strip_tags($element->plaintext));
			break;
		}
		
		if (empty($descr)) {
			foreach($html->find('div[id=productLongDescription]') as $element) {
			$descr = $element->plaintext;	
			break;
			}
		}

		foreach($html->find('img[id=pictureOfPerfection]') as $element) {
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
		$data['description'] = $descr;
		if (!empty($image)) $data['image']       = "http://store.sony.com".$image;
		
		
		return $data;
	}
}

?>