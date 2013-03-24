<?php



class Newegg
{

	/* Class constructor */
	function Newegg()
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
		
		foreach($html->find('li[id=singleFinalPrice] strong') as $element){ //for music
			$cost = trim(strip_tags($element->plaintext));
			break;
		}
	
		foreach($html->find('div[class=wrapper] span') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		if(empty($title)){
			foreach($html->find('a[id=shellShockerViewDetails] h1') as $element) //for music
			$title = trim(strip_tags($element->plaintext));
		}
		
		
		//general
		
		foreach($html->find('div[class=itmDesc]') as $element) 
			$descr .= trim(strip_tags($element->plaintext));
		
		
		if(empty($descr)){
			foreach($html->find('div[class=grpBullet]') as $element) 
			$descr .= trim(strip_tags($element->plaintext));
		}
		foreach($html->find('span[class=mainSlide] img') as $element) {
			$image = $element->src;	
		}
		
		
	
		$data['title']		 = $title;
		$data['description'] = $descr;$data['cost']        = $cost;
		$data['image']       = $image;
		
		
		return $data;
	}
}

?>