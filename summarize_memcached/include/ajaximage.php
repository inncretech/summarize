<?php 
include 'SimpleImage.php';
$path = "../upload/";

	$valid_formats = array("jpg", "png", "gif", "bmp");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					
					$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
					$tmp = $_FILES['photoimg']['tmp_name'];
					
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							
							echo "<img style='width:150px;height:120px;display:none;' src='upload/".$actual_image_name."'  class='preview'><script>$('#img-label').css('background-image',\"url('upload/".$actual_image_name."')\");</script>";
						}
					else
						echo "<img src='images/loader.gif' style='width:160px;' alt='Uploading....'/>";
									
						}
						else
						echo "<img src='images/loader.gif' style='width:160px;' alt='Uploading....'/>";
				}
				
			else
				echo "<img src='images/loader.gif' style='width:160px;' alt='Uploading....'/>";
				
			exit;
		}
?>