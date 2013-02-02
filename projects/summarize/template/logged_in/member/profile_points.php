
<div class="page-header">
	<h1>Points <small><?=$member_data['points']['total'];?> total earned.</small></h1>
</div>
<div class="prettyprint">
<?php 
for ($i = 0; $i < count($member_data['points']['data']); $i++) {
	$value = $member_data['points']['data'][$i];
	echo '<div class="alert alert-danger" style="margin-bottom:5px"><strong>'.$value['point_reason'].'</strong> <i class="icon-chevron-right"></i>  <span>'.$value['value'].'<span></div>';
}

?>
</div>

