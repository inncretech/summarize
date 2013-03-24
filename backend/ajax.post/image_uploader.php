<?php
include "../session.class.php";
include "../image.class/global.functions/SimpleImage.php";
include "../image.class/amazon.class/s3.php";
$database 		= new Database();
$session 		= new Session();
$member_data 	= $session->get();

// S3 DATA

$s3 			= new S3(S3_ACCESS, S3_SECRET);
$s3->putBucket(S3_BUCKET, S3::ACL_PUBLIC_READ);

$tmp_path 		= "../../images/upload/"; //Tmp upload image path
$valid_formats = array("jpg", "png", "gif", "bmp","JPG","PNG","GIF","BMP");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
	$name = $_FILES['photo']['name'];
	$size = $_FILES['photo']['size'];
	
	if($size!=0)
	{
		$ext = array_pop(explode(".", $name));
		$ext=strtolower($ext);
		if(in_array($ext,$valid_formats))
		{
			$ext = "jpg";
			$tmp = $_FILES['photo']['tmp_name'];
			if (isset($_GET['member'])){
				$actual_image_name = $member_data['public_id'];
				list($w, $h) = getimagesize($tmp);
				$image_profile = new SimpleImage();
				$image_profile->load($tmp);
				if (($w>200)&&($h>170)){
					if ($w>$h){
						$image_profile->resizeToHeight(170);
					}else {
						$image_profile->resizeToWidth(200);
					}
				}
				$image_profile->save($tmp_path.$actual_image_name.".".$ext);
				$s3->putObjectFile($tmp_path.$actual_image_name.".".$ext, S3_BUCKET, "m_".$actual_image_name."_normal.".$ext, S3::ACL_PUBLIC_READ);
			   
			   
			  
				$data 									= Array();
				$data['full_image_url'] 				= $actual_image_name;
				$data['width'] 							= $w;
				$data['height'] 						= $h;
				$data['created_by']						= $member_data['member_id'];


				$image_id = $database->image_table->add($data);
				$database->member_image->add($image_id,$member_data['member_id']);

				$image_small = new SimpleImage();
				$image_small->load($tmp_path.$actual_image_name.".".$ext);
				$image_small->resize(35,35);
				$image_small->save($tmp_path."s".$actual_image_name.".".$ext);
				
				$s3->putObjectFile($tmp_path."s".$actual_image_name.".".$ext, S3_BUCKET, "m_".$actual_image_name."_small.".$ext, S3::ACL_PUBLIC_READ);
				unlink($tmp_path.$actual_image_name.".".$ext);
				unlink($tmp_path."s".$actual_image_name.".".$ext);
				
				$image_s3_path = 'http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$actual_image_name.'_normal.'.$ext;
				echo "<input type='hidden' id='image_data' value='".$actual_image_name."' w='$w' h='$h'/>";
				echo "<img src='".$image_s3_path."' id='image-preview' data-src='holder.js/300x200' 	alt='300x200' style=\"max-width:none;\"/>";
			}else
			{
				$actual_image_name = time().rand(); 
				$image_product = new SimpleImage();
				$image_product->load($tmp);
				if (($w>220)&&($h>220)){
					if ($w>$h){
					$image_product->resizeToHeight(220);
					}else {
					$image_product->resizeToWidth(220);
					}
				}
				$image_product->save($tmp_path.$actual_image_name.'.'.$ext);
				
				
				$session->setValue("product_public_id",$actual_image_name);
				
				$s3->putObjectFile($tmp_path.$actual_image_name.'.'.$ext, S3_BUCKET, 'p_'.$actual_image_name.'_normal.'.$ext, S3::ACL_PUBLIC_READ);
				
				$image_small = new SimpleImage();
				$image_small->load($tmp_path.$actual_image_name.".".$ext);
				$image_small->resize(35,35);
				$image_small->save($tmp_path."s".$actual_image_name.".".$ext);
				
				$s3->putObjectFile($tmp_path."s".$actual_image_name.".".$ext, S3_BUCKET, "p_".$actual_image_name."_small.".$ext, S3::ACL_PUBLIC_READ);
				
				unlink($tmp_path.$actual_image_name.".".$ext);
				unlink($tmp_path."s".$actual_image_name.".".$ext);
				

				$image_s3_path = 'http://'.(S3_BUCKET).'.s3.amazonaws.com/p_'.$actual_image_name.'_normal.'.$ext;
				echo "<input type='hidden' id='image_data' value='".$actual_image_name."' w='$w' h='$h'/>";
				echo "<img src='".$image_s3_path."' id='image-preview' data-src='holder.js/300x200' 	alt='300x200' />";
			}
		}else
		{
			if (isset($_GET['member'])){
				echo '<input type="hidden" id="image_data" value="default.png" w="300" h="200">';
				echo '<img id="image-preview" data-src="holder.js/300x200" alt="300x200" src="http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$member_data['public_id'].'_normal.jpg">';
			}else{
				echo '<input type="hidden" id="image_data" value="default.png" w="300" h="200">';
				echo '<img id="image-preview" data-src="holder.js/300x200" alt="300x200" src="/images/default.png">';
			}			
		}
	}else
	{
		if (isset($_GET['member'])){
			echo '<input type="hidden" id="image_data" value="default.png" w="300" h="200">';
			echo '<img id="image-preview" data-src="holder.js/300x200" alt="300x200" src="http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$member_data['public_id'].'_normal.jpg">';
		}else{
			echo '<input type="hidden" id="image_data" value="default.png" w="300" h="200">';
			echo '<img id="image-preview" data-src="holder.js/300x200" alt="300x200" src="/images/default.png">';
		}
	}
		
}else echo "<script></script>";

?>