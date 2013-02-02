<?php
require_once "../session.class.php";

$database 		= new Database();
$session 		= new Session();
$member_data 	= $session->get();

if (isset($_GET['member'])){
	$path 		= "../../images/upload/member/"; //Upload image path
	$show_path 	= "images/upload/member/";
}else{
	$path		= "../../images/upload/product/"; //Upload image path
	$show_path 	= "images/upload/product/";
}
	$valid_formats = array("jpg", "png", "gif", "bmp");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photo']['name'];
			$size = $_FILES['photo']['size'];
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					
					$actual_image_name = time().".".$ext; //Image name... by default set to curent timestamp.extension
					$tmp = $_FILES['photo']['tmp_name'];
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							list($w, $h) = getimagesize($path.$actual_image_name);
						
							$data 									= Array();
							$data['full_image_url'] 				= $actual_image_name;
							$data['width'] 							= $w;
							$data['height'] 						= $h;
							$data['created_by']						= $member_data['member_id'];
							if (isset($_GET['member']))	$_SESSION['image']['full_image_url'] 	= $actual_image_name;
							
							$image_id = $database->image_table->add($data);
							
							$database->member_image->add($image_id,$member_data['member_id']);
							
							echo "<input type='hidden' id='image_data' value='".$actual_image_name."' w='$w' h='$h'/>";
							echo "<img src='".$show_path.$actual_image_name."' id='image-preview' data-src='holder.js/300x200' alt='300x200' />";
						}
					else
						echo "<script>alert('Error');</script>";				
						}
						else
						echo "<script>alert('Error');</script>";
				}
				
			else
				echo "<script>alert('Error');</script>";
				
			exit;
		}
?>