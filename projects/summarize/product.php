<?php
require_once "backend/session.class.php";
$session = new Session();
$database = new Database();
$member_data = $session->get();

$product_data          				= $database->product->get($_GET['id']);
$product_tag_id		   				= $database->product_tag->get($product_data['product_id']);
$product_data['tag']   				= $database->tag->getMultiple($product_tag_id);
$product_image_id      				= $database->product_image->get($product_data['product_id']);
$product_data['image'] 				= $database->image_table->get($product_image_id);
$product_data['created_by_data'] 	= $database->member->get($product_data['created_by']);



require_once "template/header.php";

echo "<script>var product_id = ".$product_data['product_id'].";</script>";

if ($session->check()){
	echo "<script>var member_login = true; </script>";
	require_once "template/logged_in/top_menu.php";
	require_once "template/logged_in/add_feedback_modal.php";
	require_once "template/logged_in/change_category_modal.php";
	require_once "template/logged_in/add_product_modal.php";
}else{
	echo "<script>var member_login = false; </script>";
	require_once "template/logged_out/top_menu.php";
	require_once "template/logged_out/sign_in_modal.php";
	require_once "template/logged_out/register_modal.php";
}

	?>
	<div class='search-container'>
	
	</div>
	
    <div class="container-fluid">
      <div class="container" id="spaced" style="width: 1000px;">
			<p style="text-align:right;">
				
				<a href="#" class="btn btn-primary" data-toggle="modal"  id="follow-product-btn">Follow Product</a>
			</p>
			<div class="thumbnail"  id="white-big-box-display" style="margin-bottom:10px;">
			<table>
				<tr>
					<td valign="top">
						<label id="product-image">
							<label class="image-holder">
								<img id="image-preview" data-src="holder.js/300x200" alt="300x200"   src="<?=(BASE_PRODUCT_IMAGE_URL.$product_data['image']['full_image_url']);?>">
							</label>
							<!--
							<button class="btn" id="upload-btn">
								<input type="file" style="opacity:0;position:relative;z-index:10;cursor:pointer;" name="photoimg" id="photoimg">
								<span class="upload-btn-text">Upload Image<span>
							</button>
							-->
						</label>
					</td>
					<td valign="top">
						<div class="caption" style="padding-bottom:0px;margin-bottom:10px;">
							<h3><?=$product_data['title'];?></h3>
							<p><textarea class="tagArea"><?=implode(',', $product_data['tag']);?></textarea></p>
							<p><?=$product_data['description'];?></p>
						</div>	
					</td>
				</tr>
			</table>
			</div>
			
				<a href="#" data-toggle="modal" class="btn btn-primary"  id="add-feedback-trigger">Add Feedback</a>
				<!--
				<a href="#" data-toggle="modal" class="btn btn-primary"  id="compare-product-trigger">Compare Product</a>
				<a href="#" data-toggle="modal" class="btn btn-primary"  id="forum-trigger">Forum</a>
				-->
				<a href="#" data-toggle="modal" class="btn btn-primary"  id="chart-toggle"><i class="icon-align-left icon-white"></i><span>Show Chart</span></a>
				<span style="float:right;padding: 4px;">Created by <a href="member.php?id=<?=$product_data['created_by_data']['member_id'];?>" data-toggle="modal" ><?=$product_data['created_by_data']['login'];?></a></span>
			<div class="thumbnail"  id="white-big-box-display" style="min-height:40px;margin-top:10px;">
				<div id="chart-container">
				</div>
			</div>
			<div class="thumbnail"  id="white-big-box-display" style="min-height:40px;margin-bottom:100px;margin-top:10px;">
				<div class="accordion" id="accordion2" style="margin-bottom:0px;">
					
				</div>
			</div>
			<!--
			<a href="#" class="btn btn-primary" style="float:left;margin-top:5px;" id="save-form-btn">Save</a>
			<a  href="#useLink" data-toggle="modal" class="btn btn-primary" style="float:left;margin:5px 0 0 5px;">Use link</a>
			<a href="#" class="btn btn-primary" style="float:left;margin:5px 0 0 5px;" id="reset-form-btn">Reset</a>
			-->
    </div><!--/.fluid-container-->
	</div>
<?php
if ($session->check()){
	require_once "template/logged_in/footer.php";
}else{
	require_once "template/logged_out/footer.php";
}
?>
</body>
</html>
