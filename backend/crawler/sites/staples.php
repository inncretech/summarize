<?php



class Staples
{

	/* Class constructor */
	function Staples()
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
		
		foreach($html->find('dd[class=finalPrice]') as $element){ //for music
			$cost = trim(strip_tags($element->plaintext));
			break;
		}
	
	
		foreach($html->find('div[class=gridWidth04 productDetails] h1') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		
		//general
		foreach($html->find('p[class=skuShortDescription]') as $element) 
		$descr .= trim(strip_tags($element->plaintext));
		
		if (empty($descr)){
			foreach($html->find('h2[class=skuHeadline]') as $element) {
			$descr .= trim(strip_tags($element->plaintext));
		}
		}

		foreach($html->find('div[class=scene7Placeholder] img') as $element) {
			$image = $element->src;	
		}
		
		
	
		$data['title']		 = $title;
		$data['description'] = $descr;$data['cost']        = $cost;
		$data['image']       = $image;
		
		
		return $data;
	}
}

?>