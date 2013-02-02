<?php
include "backend/session.class.php";
include "backend/global.functions.php";
$facebook 		= new Fb();
$database 		= new Database();
if(($facebook->check)&&(isset($_GET['facebook_sign_in']))){
	$session 			= new Session($_GET,$facebook->logoutUrl);
	$session->setValue("social_network_id",$facebook->data['id']);
	$tmp_member_data 	= $database->member->checkFacebook($facebook->data['id']);
	if ($tmp_member_data!=null){
		$tmp_member_data['info'] 		= $database->member_info->get($tmp_member_data['member_id']);
		$tmp_member_image_id    		= $database->member_image->get($tmp_member_data['member_id']);
		$tmp_member_data['image'] 		= $database->image_table->get($tmp_member_image_id);
		$session->sign_in($tmp_member_data);
		if ($session->getValue("next")!=""){
			Redirect($session->getValue("next"));
			$session->unsetValue("next");
		}else{
			Redirect("product.php?id=".$_GET['id']);
		}
	}
}else{
	$session 	= new Session($_GET,null);
}

$member_data = $session->get();

if ($database->report_product->check($member_data['member_id'],$_GET['id'])) Redirect("index.php");

$product_data          				= $database->product->get($_GET['id']);
$product_tag_id		   				= $database->product_tag->get($product_data['product_id']);
$product_data['tag']   				= $database->tag->getMultiple($product_tag_id);
$product_image_id      				= $database->product_image->get($product_data['product_id']);
$product_data['image'] 				= $database->image_table->get($product_image_id);
$product_data['created_by_data'] 	= $database->member->get($product_data['created_by']);

$database->view_details->add($product_data['product_id'],$member_data['member_id']);


include "template/header.php";

echo "<script>var product_id = ".$product_data['product_id'].";</script>";

if ($session->check()){
	echo "<script>var member_login = true; </script>";
	include "template/logged_in/top_menu.php";
	include "template/logged_in/add_product_modal.php";
	include "template/logged_in/change_category_modal.php";

}else{
	echo "<script>var member_login = false; </script>";
	include "template/logged_out/top_menu.php";
	include "template/logged_out/sign_in_modal.php";
	include "template/logged_out/register_modal.php";
}
include "template/add_to_compare_modal.php";
include "template/compare_products_modal.php";
if ($facebook->check) {
	echo "<script>var facebook = true;</script>";
}else{
	echo "<script>var facebook = false;</script>";
}
?>
 <div class="container" id="main">
  <div class="row">
	<div class="span9">
	  <ul class="breadcrumb">
		<li><a href="index.php">Home</a> <span class="divider">/</span></li>
		<li><a href="#" onclick="render.search('a');">Highest Rated</a> <span class="divider">/</span></li>
		<li class="active">Product</li>
	  </ul>
	  <h1> <?=$product_data['title'];?> </h1>
	  <hr />
	  <div id="myCarousel" class="carousel slide pull-left" style="margin-right: 1em; width: 220px; ">
		<!-- Carousel items -->
		<div class="carousel-inner">
		  <div class="active item"><img src="<?=(BASE_PRODUCT_IMAGE_URL.$product_data['image']['full_image_url']);?>" alt="<?=$product_data['title'];?>"></div>
		</div>
		<!-- Carousel nav -->
		<a class="carousel-control left" style="top: 47%; font-family: Arial; line-height: 0.8em; font-size: 3em;" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" style="top: 47%; font-family: Arial; line-height: 0.8em; font-size: 3em" href="#myCarousel" data-slide="next">&rsaquo;</a>
	  </div>
	  <p>
	  <?=$product_data['description'];?>
	  </p>
	  <div>
	   <textarea class="tagArea"><?=implode(',', $product_data['tag']);?></textarea></p>
	  </div>
	  <div class="clearfix"></div>

	  <div class="tabbable">
		<ul class="nav nav-tabs" style="text-align: center;">
		  <li class="active"><a href="#feedback" data-toggle="tab">Feedback</a></li>
		  <li ><a href="#graph" data-toggle="tab" onclick="refresh_chart();">Summary Graph</a></li>
		  <li><a href="#discuss" data-toggle="tab">Discuss</a></li>
		</ul>

		<div class="tab-content">
		  <div class="tab-pane  active" id="feedback">

			</div>
		  
		  <div class="tab-pane" id="graph">
		  
		  </div>
		  <div class="tab-pane" id="discuss">
			<form class="form-search">
			  <div class="input-append">
				<input type="text" class="span2 search-query" style="width: 225%" placeholder="Search FAQs">
				<button type="submit" class="btn">Search</button>
			  </div>
			</form>
			<ol id = "questionArea">
			
			</ol>
			<div class="input-append" style="margin-left: 18px;">
			  <input class="span8" id="questionText" type="text" placeholder="Ask a question!">
			  <a href="#" class="btn" onclick="return false;" type="button" id="addQuestionBtn" data-toggle="modal">+ Add</a>
			</div>
		  </div>
		</div>
	  </div>
	  <hr />
	  <h2>Highest Rated <a class="btn btn-warning pull-right" href="#" onclick="render.HighestRated();">View More <i class="icon-circle-arrow-right icon-white"></i></a></h2> 
	  <hr style="margin-top: -5px" />
	  <ul class="thumbnails" id="highest-rated">
	   
	  </ul>
		
	</div>
	<div class="span3">
	  <div class="span3" data-spy="affix" data-offset-top="0">
		<a href="#addProduct" role="button" class="btn btn-primary btn-block" data-toggle="modal" id="addProductBtn">Add Product <i class="icon-plus icon-white"></i></a>
		<a href="#" class="btn btn-success btn-block" id="follow-product-btn" data-toggle="modal">Follow Product</a>
		<a href="#addToCompare" role="button" class="btn btn-warning btn-block" data-toggle="modal">Add to Compare List</a>
		<a <?php if ($session->check()) { echo 'href="#" onclick="report.add();window.location.href=\'index.php\';"';}else{echo 'href="#signInModal" data-toggle="modal"';} ?> class="btn btn-danger btn-block">Report This Product</a>
		<?php if (($session->check())&&($facebook->check))echo '<a href="#" class="btn btn-primary btn-block" onclick="facebook.post(\''.curPageURL().'\',\''.$product_data['title'].'\');">Post on facebook</a>'; ?>
		<h3><strong>Product Compare List</strong></h3>
		<ul class="unstyled" id="compare-list">
		  
		  <li style="margin-top: 10px"><a href="#compareProducts" role="button" class="btn btn-block" data-toggle="modal"  style="background-color: whitesmoke;">Compare Listed Products</a></li>
		</ul>
		<hr />
		<!--
		<ul class="unstyled well">
		  <li><a href="#" class="btn btn-link ">Terms</a></li>
		  <li><a href="#" class="btn btn-link ">Twitter</a></li>
		  <li><a href="#" class="btn btn-link ">Contact</a></li>
		  <li><a href="#" class="btn btn-link ">About</a></li>
		  <li><a href="#" class="btn btn-link ">Support</a></li>
		</ul>
		-->
	  </div>
	</div>
  </div>
</div>
<?php
if ($session->check()){
	include "template/logged_in/footer.php";
}else{
	include "template/logged_out/footer.php";
}
?>
<script>
if ((facebook)&&(!member_login)) {
	register.checkInput("#register-form");
	$('#registerModal').modal('show');
}
compare.set('<?=addslashes ($product_data['title']);?>');
</script>
</body>
</html>
