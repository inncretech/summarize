<?php



class Ebay
{

	/* Class constructor */
	function Ebay()
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
		
		foreach($html->find('span[id=prcIsum]') as $element){ //for music
			$cost = trim(strip_tags($element->plaintext));
			break;
		}
		foreach($html->find('h1[id=itemTitle]') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		
		//general
		foreach($html->find('div[id=desc_div]') as $element) {
		$descr .= trim(strip_tags($element->plaintext));
		
		}

		foreach($html->find('img[id=icImg]') as $element) {
			$image = $element->src;	
			break;
		}
		
		
	
		$data['title']		 = $title;
		$data['description'] = $descr;$data['cost']        = $cost;
		$data['image']       = $image;
		
		
		return $data;
	}
}

?>