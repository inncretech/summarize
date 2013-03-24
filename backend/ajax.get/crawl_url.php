<?php
include "../constants.php";
include "../session.class.php";
include "../crawler/crawler.class.php";
include "../image.class/global.functions/SimpleImage.php";
include "../image.class/amazon.class/s3.php";

// S3 DATA

$url 			= $_POST['url'];
$crawler 		= new crawler();
$domain 		= $crawler->getDomain($url);

function renderJson($data){
	$url 	= $data['image'];
	if (!empty($url)){
		$file = fopen($url,"rb");
		if($file){
		$directory = "../../images/upload/"; // Directory to upload tmp files to.
		
		if( preg_match('/.(?:jpe?g|png|gif)/', $url, $matches) ) {
			$ext = substr($matches[0], 1 );
		}
		if (empty($ext)) $ext = "jpg";

		$filename = time().rand();
		$session = new Session();
		$session->setValue("product_public_id",$filename);
		$newfile = fopen($directory . $filename.".".$ext, "wb"); // creating new file on local server
		if($newfile){
			while(!feof($file)){
			// Write the url file to the directory.
			fwrite($newfile,fread($file,1024 * 8),1024 * 8); // write the file to the new directory at a rate of 8kb/sec. until we reach the end.
			}
		} else { $data['image']='Could not establish new file (' .$directory.$filename.".".$ext.') on local server. Be sure to CHMOD your directory to 777.' ; }
		
		} else { $data['image']='Could not locate the file: ' .$url.'' ; }
		 
		list($w, $h) = getimagesize($directory.$filename.".".$ext);
		
		$data['width']  = $w;
		$data['height'] = $h;
		$data['image']  = $filename;
		$s3 			= new S3(S3_ACCESS, S3_SECRET);
		
		$s3->putBucket(S3_BUCKET, S3::ACL_PUBLIC_READ);
		$s3->putObjectFile($directory.$filename.".".$ext, S3_BUCKET, "p_".$filename."_normal.jpg", S3::ACL_PUBLIC_READ);
		
		$image_small = new SimpleImage();
		$image_small->load($directory.$filename.".".$ext);
		$image_small->resize(35,35);
		$image_small->save($directory."s".$filename.".".$ext);
		
		$s3->putObjectFile($directory."s".$filename.".".$ext, S3_BUCKET, "p_".$filename."_small.".$ext, S3::ACL_PUBLIC_READ);
		unlink($directory.$filename.".".$ext);
		unlink($directory."s".$filename.".".$ext);
		
	}	
	$data['url'] = $_POST['url'];
	$data = parseData($data);

	$session->setValue('external','1');
	echo json_encode($data);
}

function parseData($data){
	
	$data['description'] 	= str_replace(array("\r", "\n", "\t", "\v"), '',preg_replace("/&#?[a-z0-9]{2,8};/i","",$data['description']));
	$data['title'] 			= str_replace(array("\r", "\n", "\t", "\v"), '',preg_replace("/&#?[a-z0-9]{2,8};/i","",$data['title']));
	$data['cost'] 			= str_replace(array("\r", "\n", "\t", "\v"), '',preg_replace("/&#?[a-z0-9]{2,8};/i","",$data['cost']));
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