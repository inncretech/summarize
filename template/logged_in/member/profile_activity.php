
<div class="prettyprint" style="background-color: transparent;border: none">
<?php 
for ($i = 0; $i < count($member_data['activity']); $i++) {
	$value 	= $member_data['activity'][$i];
	$seo_title 	= $database->product->getSeoTitle($value['product_id']);
	$text 	= '';
	switch ($value['type']){
		case "Like":
			$text = "Liked <strong>".$value['comment']."</strong> on <a href='".SITE_ROOT."/product/".$seo_title."'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a>";
		break;
		case "Feedback":
			$text = "Added feedback <strong>".$value['comment']."</strong> for <a href='".SITE_ROOT."/product/".$seo_title."'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a>";
		break;
		case "Tag":
			$text = "Added tag <span id='custom-tag'>".$value['comment']."</span> for <a href='".SITE_ROOT."/product/".$seo_title."'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a>";
		break;
		case "Tag Remove":
			$text = "Removed tag <span id='custom-tag'>".$value['comment']."</span> for <a href='".SITE_ROOT."/product/".$seo_title."'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a>";
		break;
		case "Product":
			$text = "Added the product <a href='".SITE_ROOT."/product/".$seo_title."'>".$value['product_title']."</a><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['comment'];
		break;
		case "Question":
			$text = "Asked on <a href='".SITE_ROOT."/product/".$seo_title."'>".$value['product_title']."</a><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'><strong>".$value['comment']."</strong>";
		break;
		case "Answer":
			$text = "Answered on <a href='".SITE_ROOT."/product/".$seo_title."'>".$value['product_title']."</a><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'><strong>".$value['comment']."</strong>";
		break;
		case "Answer Rate":
			$text = "Rated answer on <a href='".SITE_ROOT."/product/".$seo_title."'>".$value['product_title']."</a><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['comment'];
		break;
	}
	echo '<p style="margin:0px">'.$text.'</p>';
	if ($i!= count($member_data['activity'])-1)	echo '<hr style="margin:5px;">';
} 

?>
</div>

