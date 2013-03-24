<ul class="unstyled">     
<?php 
for ($i = 0; $i < count($member_data['notifications']); $i++) {
	$value 				= $member_data['notifications'][$i];
	$tmp_member 		= $database->member->get($value['created_by']);
	$seo_title 			= $database->product->getSeoTitle($value['product_id']);
	switch ($value['type']){
		case "Like":
			$text = '<li class="notification"><a href="#" class="remove" onclick="notification.close(this);" data='.$value['id'].' id="close-notification"><i class="icon icon-remove"></i></a><a href="'.SITE_ROOT."/member/".$tmp_member['seo_title'].'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$value['created_by_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$tmp_member['login'].'</a> liked "'.$value['comment'].'" on <a href="'.SITE_ROOT."/product/".$seo_title.'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/p_'.$value['product_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$value['product_title'].'</a></li>';
		break;
		case "Feedback":
			$text = '<li class="notification"><a href="#" class="remove" onclick="notification.close(this);" data='.$value['id'].' id="close-notification"><i class="icon icon-remove"></i></a> <a href="'.SITE_ROOT."/member/".$tmp_member['seo_title'].'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$value['created_by_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$tmp_member['login'].'</a> added a feedback "'.$value['comment'].'" for <a href="'.SITE_ROOT."/product/".$seo_title.'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/p_'.$value['product_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$value['product_title'].'</a></li>';
		break;
		case "Tag":
			$text = '<li class="notification"><a href="#" class="remove" onclick="notification.close(this);" data='.$value['id'].' id="close-notification"><i class="icon icon-remove"></i></a> <a href="'.SITE_ROOT."/member/".$tmp_member['seo_title'].'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$value['created_by_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$tmp_member['login'].'</a> '.$value['comment'].' on <a href="'.SITE_ROOT."/product/".$seo_title.'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/p_'.$value['product_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$value['product_title'].'</a></li>';
		break;
		case "Question":
			$text = '<li class="notification"><a href="#" class="remove" onclick="notification.close(this);" data='.$value['id'].' id="close-notification"><i class="icon icon-remove"></i></a> <a href="'.SITE_ROOT."/member/".$tmp_member['seo_title'].'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$value['created_by_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$tmp_member['login'].'</a> added a question "'.$value['comment'].'" on <a href="'.SITE_ROOT."/product/".$seo_title.'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/p_'.$value['product_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$value['product_title'].'</a></li>';
		break;
		case "Answer":
			$text = '<li class="notification"><a href="#" class="remove" onclick="notification.close(this);" data='.$value['id'].' id="close-notification"><i class="icon icon-remove"></i></a> <a href="'.SITE_ROOT."/member/".$tmp_member['seo_title'].'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$value['created_by_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$tmp_member['login'].'</a> added an answer "'.$value['comment'].'" on <a href="'.SITE_ROOT."/product/".$seo_title.'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/p_'.$value['product_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$value['product_title'].'</a></li>';
		break;
		case "Answer Rate":
			$text = '<li class="notification"><a href="#" class="remove" onclick="notification.close(this);" data='.$value['id'].' id="close-notification"><i class="icon icon-remove"></i></a> <a href="'.SITE_ROOT."/member/".$tmp_member['seo_title'].'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$value['created_by_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$tmp_member['login'].'</a> rated an answer "'.$value['comment'].'" on <a href="'.SITE_ROOT."/product/".$seo_title.'"><img src="http://'.(S3_BUCKET).'.s3.amazonaws.com/p_'.$value['product_public_id'].'_small.jpg" style="margin:3px;width:25px;height:25px;">'.$value['product_title'].'</a></li>';
		break;
	}
	
	echo $text;
	
} 

?>
</ul>
