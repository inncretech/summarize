<?php



class Sears
{

	/* Class constructor */
	function Sears()
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
		
		foreach($html->find('span[class=pricing]') as $element){ //for music
			$cost = trim(strip_tags($element->plaintext));
			break;
		}
	
		foreach($html->find('div[class=productName] h1') as $element) //for music
		$title = trim(strip_tags($element->plaintext));
		
		
		//general
		foreach($html->find('div[id=desc1] p') as $element) {
		$descr .= trim(strip_tags($element->plaintext));
			break;
		}

		foreach($html->find('div[class=productImage] img') as $element) {
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