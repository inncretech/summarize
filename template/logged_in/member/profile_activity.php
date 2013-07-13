
<div class="prettyprint" style="background-color: transparent;border: none">
<?php 
if (count($member_data['activity'])==0) echo "<div class='alert alert-warning'>No activity at this time.</div>";
for ($i = 0; $i < count($member_data['activity']); $i++) {
	
	$value 	= $member_data['activity'][$i];
	$seo_title 	= $database->product->getSeoTitle($value['product_id']);
	$texta 	= '';
	
	switch ($value['type']){
		case "Like":
			$texta = "<a href='".SITE_ROOT."/product/".$seo_title."' ><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> liked </strong> <strong><i>\"".$value['comment']."\"</i></strong>";
		break;
		case "Feedback":
			$texta = "<a href='".SITE_ROOT."/product/".$seo_title."' ><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> added feedback </strong> <strong><i>\"".$value['comment']."\"</i></strong>";
		break;
		case "Tag":
			$texta = "<a href='".SITE_ROOT."/product/".$seo_title."' ><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> added tag  </strong><span id='custom-tag'>".$value['comment']."</span>";
		break;
		case "Tag Remove":
			$texta = "<a href='".SITE_ROOT."/product/".$seo_title."' ><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> removed tag   </strong><span id='custom-tag'>".$value['comment']."</span>";
		break;
		case "Product":
			$texta = "<a href='".SITE_ROOT."/product/".$seo_title."' ><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> added product </strong>";
		break;
		case "Question":
			$texta = "<a href='".SITE_ROOT."/product/".$seo_title."' ><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> asked </strong> <strong><i>\"".$value['comment']."\"</i></strong>";
		break;
		case "Answer":
			$texta = "<a href='".SITE_ROOT."/product/".$seo_title."' ><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> answered </strong> <strong><i>\"".$value['comment']."\"</i></strong>";
		break;
		case "Answer Rate":
			$texta = "<a href='".SITE_ROOT."/product/".$seo_title."' ><img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['product_public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>".$value['product_title']."</a> <strong style='color: red;'> rated answer </strong> <strong><i>\"".$value['comment']."\"</i></strong>";
		break;
	}
	echo '<p style="margin:0px;color:#555;font-weight:bold">'.$texta.'</p>';
	
} 

?>
</div>

