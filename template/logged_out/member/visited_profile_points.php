
<div class="prettyprint" style="background-color: transparent;border: none">
<?php 
for ($i = 0; $i < count($visited_member_data['points']['data']); $i++) {
	$value = $visited_member_data['points']['data'][$i];
	echo '<div class="alert alert-danger" style="margin-bottom:5px;background-color:transparent;color:#555;padding:0;"><strong>'.$value['point_reason'].'</strong> <i class="icon-chevron-right"></i>  <span>'.$value['value'].'<span></div>';
	if ($i!= count($visited_member_data['points']['data'])-1)	echo '<hr style="margin:5px;">';
}

?>
</div>

