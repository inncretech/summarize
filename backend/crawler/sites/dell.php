<?php



class Dell
{

	/* Class constructor */
	function Dell()
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
		
		foreach($html->find('span[class=price]') as $element){ //for music
			$cost = trim(strip_tags($element->plaintext));
			break;
		}
	
		foreach($html->find('div[id=pagetitle]') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		
		//general
		foreach($html->find('p[class=prodDesc]') as $element) 
		$descr .= trim(strip_tags($element->plaintext));


		foreach($html->find('div[class=tabFeature inlineContent] div[class=leftImgContainer] img') as $element) {
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