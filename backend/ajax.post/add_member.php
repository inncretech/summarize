<?php
include "../constants.php";
include "../session.class.php";
include "../email.system/amazon.email.php";
include "../global.functions.php";
include "../image.class/global.functions/SimpleImage.php";
include "../image.class/amazon.class/s3.php";

$database = new Database();
$session  = new Session();
$facebook = new Fb();
$twitter  = new Tw();

$s3 			= new S3(S3_ACCESS, S3_SECRET);
$s3->putBucket(S3_BUCKET, S3::ACL_PUBLIC_READ);

if ($session->getValue("social_network_name")=="facebook"){
	$data = $session->getValue('social_network_data');
	$data['login'] = $data['username'];
	$data['password'] = time();
	$data['image'] = "https://graph.facebook.com/".$data['id']."/picture?type=large";
}else{
	$data = $database->escape($_POST);
}

$data["social_network_id"] 	= $session->getValue("social_network_id");
$data["public_id"]			= time().rand();
$data['member_id'] 			= $database->member->add($data);
$member_id = $data['member_id'];

$database->member_info->add($data);
$database->member_image->add(0,$data['member_id']);

$url 	= $data['image'];
if (!empty($url)){
	$file = fopen($url,"rb");
	if($file){
	$directory = "../../images/upload/"; // Directory to upload files to.
	
	if( preg_match('/.(?:jpe?g|png|gif)/', $url, $matches) ) {
		$ext = substr($matches[0], 1 );
	}
	if (empty($ext)) $ext = "jpg";

	$filename = $data["public_id"].".".$ext;
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
	$data['full_image_url'] = $filename;
	
	list($w, $h) = getimagesize($directory.$filename);
	$image_profile = new SimpleImage();
	$image_profile->load($directory.$filename);
	if (($w>200)&&($h>170)){
		if ($w>$h){
			$image_profile->resizeToHeight(170);
		}else {
			$image_profile->resizeToWidth(200);
		}
	}
	$image_profile->save($directory.$filename);
	$s3->putObjectFile($directory.$filename, S3_BUCKET, "m_".$data["public_id"]."_normal.jpg", S3::ACL_PUBLIC_READ);
   
   
  
	$tmp_data 									= Array();
	$tmp_data['full_image_url'] 				= $data["public_id"];
	$tmp_data['width'] 							= $w;
	$tmp_data['height'] 						= $h;
	$tmp_data['created_by']						= $data['member_id'];


	$image_id = $database->image_table->add($tmp_data);
	$database->member_image->add($image_id,$data['member_id']);

	$image_topMenu = new SimpleImage();
	$image_topMenu->load($directory.$filename);
	$image_topMenu->resize(35,35);
	$image_topMenu->save($directory."s".$filename);
	
	$s3->putObjectFile($directory."s".$filename, S3_BUCKET, "m_".$data["public_id"]."_small.jpg", S3::ACL_PUBLIC_READ);
	unlink($directory.$filename);
	unlink($directory."s".$filename);
	
}else{
	$data['width'] = "300";
	$data['height'] = "200";
	$data['full_image_url'] = "default.png";
}


	


$ses = new AmazonEmail();
$subject = "SummarizIt.com Registration";
$message = "Welcome to SummarizIt.com here are you credentials:\n Username: ".$data['login']."\n Password: ".$data['password'] ;
$ses->send($data["email"],$subject,$message);

if ($session->getValue("social_network_name")=="facebook"){
	$session->refresh();
	$session->setValue("social_network_name","facebook");
	$session->setValue("social_network_data",$facebook->data);
	$session->setValue("social_network_id",$facebook->social_network_id);
	
	Redirect(SITE_ROOT."/index.php");
}else{
	Redirect(SITE_ROOT."/index.php?sign_out=true");
}
?>