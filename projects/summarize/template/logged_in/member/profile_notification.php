<div class="page-header">
	<h1>Notifications <small>received.</small></h1>
  </div>
<div class="prettyprint">

           
           
          
<?php 
for ($i = 0; $i < count($member_data['notifications']); $i++) {
	$value = $member_data['notifications'][$i];
	echo '<div class="alert alert-info" style="margin-bottom:0px"><button type="button" class="close" data-dismiss="alert" onclick="notification.close(this);" data='.$value['id'].' id="close-notification">&times;</button><strong><a href="product.php?id='.$value['product_id'].'">'.$value['product_title'].'</a></strong> <i class="icon-chevron-right"></i> <strong>'.$value['type'].' <i class="icon-chevron-right"></i> </strong> <span>'.$value['comment'].'<span></div>';
	if ($i!= count($member_data['activity'])-1)	echo '<hr style="margin:5px;">';
} 

?>
</div>

