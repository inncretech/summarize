
<div class="page-header">
	<h1>Activity <small>recent done by the user.</small></h1>
</div>
<div class="prettyprint">
<?php 
for ($i = 0; $i < count($visited_member_data['activity']); $i++) {
	$value = $visited_member_data['activity'][$i];
	echo '<p style="margin:0px"><strong><a href="product.php?id='.$value['product_id'].'">'.$value['product_title'].'</a></strong> <i class="icon-chevron-right"></i> <strong>'.$value['type'].'</strong> <i class="icon-chevron-right"></i> <span>'.$value['comment'].'<span></p>';
	if ($i!= count($visited_member_data['activity'])-1)	echo '<hr style="margin:5px;">';
} 

?>
</div>

