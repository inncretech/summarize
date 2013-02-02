
<div class="page-header">
	<h1>Activity <small>recent done by you.</small></h1>
</div>
<div class="prettyprint" style="background-color: transparent;border: none">
<?php 
for ($i = 0; $i < count($member_data['activity']); $i++) {
	$value 	= $member_data['activity'][$i];
	$text 	= '';
	switch ($value['type']){
		case "Like":
			$text = "Liked \"".$value['comment']."\" on <a href='product.php?id='".$value['product_id']."'>".$value['product_title']."</a>";
		break;
		case "Feedback":
			$text = "Added feedback \"".$value['comment']."\" for <a href='product.php?id='".$value['product_id']."'>".$value['product_title']."</a>";
		break;
		case "Tag":
			$text = "Added tag <a href='#' class='btn btn-info'>".$value['comment']."</a> for <a href='product.php?id='".$value['product_id']."'>".$value['product_title']."</a>";
		break;
		case "Product":
			$text = "Added the product <a href='product.php?id='".$value['product_id']."'>".$value['product_title']."</a> ".$value['comment'];
		break;
		case "Question":
			$text = "Asked on <a href='product.php?id='".$value['product_id']."'>".$value['product_title']."</a> ".$value['comment'];
		break;
		case "Answer":
			$text = "Answered on <a href='product.php?id='".$value['product_id']."'>".$value['product_title']."</a> ".$value['comment'];
		break;
		case "Answer Rate":
			$text = "Rated answer on <a href='product.php?id='".$value['product_id']."'>".$value['product_title']."</a> ".$value['comment'];
		break;
	}
	echo '<p style="margin:0px">'.$text.'</p>';
	if ($i!= count($member_data['activity'])-1)	echo '<hr style="margin:5px;">';
} 

?>
</div>

