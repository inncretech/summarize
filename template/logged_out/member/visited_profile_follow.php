
<div class="prettyprint" style="background-color: transparent;border: none">
<?php 
if (count($visited_member_data['follow'])==0){
echo '<div class="alert alert-warning" style="margin:0px;"><strong>No products followed at this time.</strong></div>';
}
for ($i = 0; $i < count($visited_member_data['follow']); $i++) {
	$value = $database->product->get($visited_member_data['follow'][$i]['product_id']);
	echo '<div class="alert" style="margin-bottom:10px;background-color:transparent;color:#555;padding:0;cursor:pointer;height:20px;">';
	echo '<div style="width:425px;line-height: 30px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;float:left;">';
	echo "<img src='http://".(S3_BUCKET).".s3.amazonaws.com/p_".$value['public_id']."_small.jpg' style='margin:3px;width:25px;height:25px;'>";
	echo '<a href="'.SITE_ROOT.'/product/'.$value['seo_title'].'" style="color:#555;"><strong>'.$value['title'].'</strong></a>';
	echo '</div>';
	echo '</div>';
	
}

?>
</div>

