<?php
include "../constants.php";
include "../session.class.php";
include "../crawler/crawler.class.php";
include "../image.class/global.functions/SimpleImage.php";
include "../image.class/amazon.class/s3.php";

// S3 DATA

$url 			= $_POST['url'];

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
	echo $filename;
}	
?>