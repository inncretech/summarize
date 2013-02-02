<?php
include "../crawler/crawler.class.php";

$url = $_POST['url'];

$crawler 		= new crawler();
$domain 		= $crawler->getDomain($url);
function renderJson($data){
		$url 	= $data['image'];
		if (!empty($url)){
			$file = fopen($url,"rb");
			if($file){
			$directory = "../../images/upload/product/"; // Directory to upload files to.
			
			if( preg_match('/.(?:jpe?g|png|gif)/', $url, $matches) ) {
				$ext = substr($matches[0], 1 );
			}
			if (empty($ext)) $ext = "jpg";
			$rand = time();
			$filename = $rand .".".$ext;
			$newfile = fopen($directory . $filename, "wb"); // creating new file on local server
			if($newfile){
			while(!feof($file)){
			// Write the url file to the directory.
			fwrite($newfile,fread($file,1024 * 8),1024 * 8); // write the file to the new directory at a rate of 8kb/sec. until we reach the end.
			}
			
			} else { $data['image']='Could not establish new file (' .$directory.$filename.') on local server. Be sure to CHMOD your directory to 777.' ; }
			
			} else { $data['image']='Could not locate the file: ' .$url.'' ; }
			 
			list($w, $h) = getimagesize($directory.$filename);
			$data['width'] = $w;
			$data['height'] = $h;
			$data['image'] = $filename;
		}else{
		$data['width'] = "300";
		$data['height'] = "200";
		$data['image'] = "default.png";
		}
		$data = parseData($data);
		echo json_encode($data);
}

function parseData($data){
	
	$data['description'] 	= str_replace(array("\r", "\n", "\t", "\v"), '',preg_replace("/&#?[a-z0-9]{2,8};/i","",$data['description']));
	$data['title'] 			= str_replace(array("\r", "\n", "\t", "\v"), '',preg_replace("/&#?[a-z0-9]{2,8};/i","",$data['title']));
	
	return $data;
}

switch ($domain){
	case "amazon":
		$data 	= $crawler->amazon->getData($url);
		renderJson($data);
	break;
	case "bestbuy":
		$data 	= $crawler->bestbuy->getData($url);
		renderJson($data);
	break;
	case "walmart":
		$data 	= $crawler->walmart->getData($url);
		renderJson($data);
	break;
	case "staples":
		$data 	= $crawler->staples->getData($url);
		renderJson($data);
	break;
	case "newegg":
		$data 	= $crawler->newegg->getData($url);
		renderJson($data);
	break;
	case "dell":
		$data 	= $crawler->dell->getData($url);
		renderJson($data);
	break;
	case "ebay":
		$data 	= $crawler->ebay->getData($url);
		renderJson($data);
	break;
	case "sears":
		$data 	= $crawler->sears->getData($url);
		renderJson($data);
	break;
	case "sony":
		$data 	= $crawler->sony->getData($url);
		renderJson($data);
	break;
	case "panasonic":
		$data 	= $crawler->panasonic->getData($url);
		renderJson($data);
	break;
	case "macys":
		$data 	= $crawler->macys->getData($url);
		renderJson($data);
	break;
	case "toysrus":
		$data 	= $crawler->toysrus->getData($url);
		renderJson($data);
	break;
	case "officedepot":
		$data 	= $crawler->officedepot->getData($url);
		renderJson($data);
	break;
}
?>