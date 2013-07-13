
<div class="prettyprint" style="background-color: transparent;border: none">
<?php 
for ($i = 0; $i < count($visited_member_data['activity']); $i++) {
	$value 		= $visited_member_data['activity'][$i];
	$seo_title 	= $database->product->getSeoTitle($value['product_id']);
	$text 	= '';
	switch ($value['type']){
		case "Like":
			$text = "<a href='".SITE_ROOT."/product/".$seo_title."' style='color:#555;font-weight:bold;'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> liked </strong> <strong><i>\"".$value['comment']."\"</i></strong>";
		break;
		case "Feedback":
			$text = "<a href='".SITE_ROOT."/product/".$seo_title."' style='color:#555;font-weight:bold;'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> added feedback </strong> <strong><i>\"".$value['comment']."\"</i></strong>";
		break;
		case "Tag":
			$text = "<a href='".SITE_ROOT."/product/".$seo_title."' style='color:#555;font-weight:bold;'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> added tag  </strong><span id='custom-tag'>".$value['comment']."</span>";
		break;
		case "Tag Remove":
			$text = "<a href='".SITE_ROOT."/product/".$seo_title."' style='color:#555;font-weight:bold;'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> removed tag   </strong><span id='custom-tag'>".$value['comment']."</span>";
		break;
		case "Product":
			$text = "<a href='".SITE_ROOT."/product/".$seo_title."' style='color:#555;font-weight:bold;'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> added product </strong>";
		break;
		case "Question":
			$text = "<a href='".SITE_ROOT."/product/".$seo_title."' style='color:#555;font-weight:bold;'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> asked </strong> <strong><i>\"".$value['comment']."\"</i></strong>";
		break;
		case "Answer":
			$text = "<a href='".SITE_ROOT."/product/".$seo_title."' style='color:#555;font-weight:bold;'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> answered </strong> <strong><i>\"".$value['comment']."\"</i></strong>";
		break;
		case "Answer Rate":
			$text = "<a href='".SITE_ROOT."/product/".$seo_title."' style='color:#555;font-weight:bold;'><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> rated answer </strong> <strong><i>\"".$value['comment']."\"</i></strong>";
		break;
	}
	echo '<p style="margin:0px;">'.$text.'</p>';
} 

?>
</div>

