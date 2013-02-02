<div class="page-header">
	<h1>Notifications <small></small></h1>
  </div>
<div class="prettyprint" style="background-color: transparent;border: none">

           
           
          
<?php 
for ($i = 0; $i < count($member_data['notifications']); $i++) {
	$value 		= $member_data['notifications'][$i];
	$tmp_member = $database->member->get($value['created_by']);
	switch ($value['type']){
		case "Like":
			$text = '<div class="alert alert-info" style="background:transparent;color:#555;padding: 0;margin-bottom:0px"><button type="button" class="close" data-dismiss="alert" onclick="notification.close(this);" data='.$value['id'].' id="close-notification">&times;</button><a href="member.php?id='.$tmp_member['member_id'].'">'.$tmp_member['login'].'</a> liked "'.$value['comment'].'" on <a href="product.php?id='.$value['product_id'].'">'.$value['product_title'].'</a></div>';
		break;
		case "Feedback":
			$text = '<div class="alert alert-info" style="background:transparent;color:#555;padding: 0;margin-bottom:0px"><button type="button" class="close" data-dismiss="alert" onclick="notification.close(this);" data='.$value['id'].' id="close-notification">&times;</button><a href="member.php?id='.$tmp_member['member_id'].'">'.$tmp_member['login'].'</a> added a feedback "'.$value['comment'].'" for <a href="product.php?id='.$value['product_id'].'">'.$value['product_title'].'</a></div>';
		break;
		case "Tag":
			$text = '<div class="alert alert-info" style="background:transparent;color:#555;padding: 0;margin-bottom:0px"><button type="button" class="close" data-dismiss="alert" onclick="notification.close(this);" data='.$value['id'].' id="close-notification">&times;</button><a href="member.php?id='.$tmp_member['member_id'].'">'.$tmp_member['login'].'</a> '.$value['comment'].' on <a href="product.php?id='.$value['product_id'].'">'.$value['product_title'].'</a></div>';
		break;
		case "Question":
			$text = '<div class="alert alert-info" style="background:transparent;color:#555;padding: 0;margin-bottom:0px"><button type="button" class="close" data-dismiss="alert" onclick="notification.close(this);" data='.$value['id'].' id="close-notification">&times;</button><a href="member.php?id='.$tmp_member['member_id'].'">'.$tmp_member['login'].'</a> added a question "'.$value['comment'].'" on <a href="product.php?id='.$value['product_id'].'">'.$value['product_title'].'</a></div>';
		break;
		case "Answer":
			$text = '<div class="alert alert-info" style="background:transparent;color:#555;padding: 0;margin-bottom:0px"><button type="button" class="close" data-dismiss="alert" onclick="notification.close(this);" data='.$value['id'].' id="close-notification">&times;</button><a href="member.php?id='.$tmp_member['member_id'].'">'.$tmp_member['login'].'</a> added an answer "'.$value['comment'].'" on <a href="product.php?id='.$value['product_id'].'">'.$value['product_title'].'</a></div>';
		break;
		case "Answer Rate":
			$text = '<div class="alert alert-info" style="background:transparent;color:#555;padding: 0;margin-bottom:0px"><button type="button" class="close" data-dismiss="alert" onclick="notification.close(this);" data='.$value['id'].' id="close-notification">&times;</button><a href="member.php?id='.$tmp_member['member_id'].'">'.$tmp_member['login'].'</a> rated an answer "'.$value['comment'].'" on <a href="product.php?id='.$value['product_id'].'">'.$value['product_title'].'</a></div>';
		break;
	}
	
	echo $text;
	if ($i!= count($member_data['activity'])-1)	echo '<hr style="margin:5px;">';
} 

?>
</div>

