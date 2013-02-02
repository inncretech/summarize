<?php
require_once "../crawler/crawler.class.php";

$url = $_POST['url'];

$crawler 		= new crawler();
$domain 		= $crawler->getDomain($url);

switch ($domain){
	case "amazon":
		$data 	= $crawler->amazon->getData($url);
		$url 	= $data['image'];
		
		$file = fopen($url,"rb");
		if($file){
		$directory = "../../images/upload/product/"; // Directory to upload files to.
		$valid_exts = array("jpg","jpeg","gif","png"); // default image only extensions
		$ext = end(explode(".",strtolower(basename($url))));
		if(in_array($ext,$valid_exts)){
		$rand = time();
		$filename = $rand .".".$ext;
		$newfile = fopen($directory . $filename, "wb"); // creating new file on local server
		if($newfile){
		while(!feof($file)){
		// Write the url file to the directory.
		fwrite($newfile,fread($file,1024 * 8),1024 * 8); // write the file to the new directory at a rate of 8kb/sec. until we reach the end.
		}
		
		} else { $data['image']='Could not establish new file (' .$directory.$filename.') on local server. Be sure to CHMOD your directory to 777.' ; }
		} else { $data['image']='Invalid file type. Please try another file.' ; }
		} else { $data['image']='Could not locate the file: ' .$url.'' ; }
		 
		list($w, $h) = getimagesize($directory.$filename);
		$data['width'] = $w;
		$data['height'] = $h;
		$data['image'] = $filename;
		echo json_encode($data);
	break;
}
?>