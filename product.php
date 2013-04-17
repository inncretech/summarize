<?php
include "backend/session.class.php";		// Base Classes
include "backend/global.functions.php";		// Global Functions
$session 		= new Session();
$database 		= new Database();
$facebook 		= new Fb();
$twitter 		= new Tw();

if (!isset($_GET['seo'])){ 
	Redirect(SITE_ROOT);
}else{
	$product_data = $database->product->checkSeoTitle($_GET['seo']);
	$product_data == false ? Redirect(SITE_ROOT) : $_GET['id'] = $product_data['product_id'];
	$product_data['feedback_data'] = $database->product_feedback->getByProduct($product_data['product_id']);
}

// ######################## Sign Out Check
if (isset($_GET['sign_out']))
{
	$session->refresh();
	$session->getValue("social_network_name")=="facebook" ? Redirect($facebook->logoutUrl) : Redirect($_SERVER['PHP_SELF']);
}

// ######################## Member Verifications
if (!$session->check()){
	$sn_id = $session->getValue("social_network_id");
	if (isset($sn_id)){
		$member_data = $database->member->checkSocialNetwork($sn_id);
		if ($member_data!=null){
			$member_image_id		= $database->member_image->get($member_data['member_id']);
			$member_data['image'] 	=  $database->image_table->get($member_image_id);
			$session->sign_in($member_data);
			Redirect($_SERVER['PHP_SELF']);
		}
	}
}

// ######################## Retrive Session Data
$member_data = $session->get();

$database->report_product->check($member_data['member_id'],$_GET['id']) ? Redirect("index.php") : '';

$product_tag_id		   				= $database->product_tag->get($product_data['product_id']);
$product_data['tag']   				= $database->tag->getMultiple($product_tag_id);
$product_data['created_by_data'] 	= $database->member->get($product_data['created_by']);
$product_data['info']				= $database->product_info->getByProduct($product_data['product_id']);

$database->view_details->add($product_data['product_id'],$member_data['member_id']);


// ######################## Load CSS And Header Data
include "template/header.php";

if ($session->check()){
	include "template/logged_in/top_menu.php";
	include "template/logged_in/add_product_modal.php";
	include "template/logged_in/change_category_modal.php";

}else{
	include "template/logged_out/top_menu.php";
	include "template/logged_out/sign_in_modal.php";
	include "template/logged_out/register_modal.php";
}
include "template/summarize_with_friend.php";
include "template/add_to_compare_modal.php";
include "template/advanced_search_modal.php";


// ######################## Initialize JS Variables
echo "<script> var member_login  		= ".($session->check() 									   ? "true" : "false" )."; </script>";
echo "<script> var facebook      		= ".($session->getValue("social_network_name")=="facebook" ? "true" : "false" )."; </script>";
echo "<script> var twitter       		= ".($session->getValue("social_network_name")=="twitter"  ? "true" : "false" )."; </script>";
echo "<script> var site_root 	 		= '".SITE_ROOT."'; </script>";
echo "<script> var s3_base_link  		= 'http://".S3_BUCKET."'; </script>";
echo "<script> var product_id         	= ".$product_data['product_id'].";</script>";
echo "<script> var similar_base_product = ".$product_data['product_id'].";</script>";
echo "<script> var pageUrl  	 		= '".curPageURL()."'; </script>";
echo "<script> var compareItems 		= true; </script>";
echo "<script> var product_title 		= '".$product_data['title']."';</script>";

?>
<script type="text/javascript" src="<?=SITE_ROOT;?>/js/facebook.functions.js"></script>
<script> facebookAPP.init('<?=FB_APP_ID?>','<?=SITE_ROOT?>'); </script>
<div class="container" id="main">
	<div class="row">
		<div class="span9 product-container">
			<ul class="breadcrumb">

				<li>
					<a href="#" onclick="render.HighestRated(0);">Highest Rated</a>
					<span class="divider">|</span>
				</li>
				<li>
					<a href="#" onclick="render.MostViewed(0);">Most Viewed</a>
					<span class="divider">|</span>
				</li>
				<li>
					<a href="#" onclick="render.RecentlyAdded(0);">Recently Added</a>
					
				</li>
				
			</ul>
			<h1 id="product-title"> <?=$product_data['title'];?> </h1>
			<?=($product_data['info']['external']=="1" ? '<div style="float: right;"><a href="'.$product_data['info']['product_url'].'" target="_blank"><img src="'.SITE_ROOT.'/images/earth-icon.png" style="width:40px;"></a></div>' : '');?>
			<hr>
			<div id="myCarousel" class="carousel slide pull-left" style="margin-right: 1em; width: 220px; ">
				<!-- Carousel items -->
				<div class="carousel-inner breadcrumb" style="padding:0px;">
					<div class="active item">
						<img src="<?='http://'.(S3_BUCKET).'.s3.amazonaws.com/p_'.$product_data['public_id'].'_normal.jpg';?>" alt="<?=$product_data['title'];?>">
					</div>
				</div>
				<!-- Carousel nav -->
				<a class="carousel-control left" style="top: 47%; font-family: Arial; line-height: 0.8em; font-size: 3em;" href="#myCarousel" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" style="top: 47%; font-family: Arial; line-height: 0.8em; font-size: 3em" href="#myCarousel" data-slide="next">&rsaquo;</a>
			</div>
			<p><?=$product_data['description'];?></p>
			<div style="padding-left: 222px;">
				<textarea class="tagArea"><?=implode(',', $product_data['tag']);?></textarea>
			</div>
			
			<div class="clearfix"></div>

			<div class="tabbable">
			<ul class="nav nav-tabs" style="text-align: center;margin: 0px;">
				<li class="active">
					<a href="#feedback" data-toggle="tab">Feedback</a>
				</li>
				<li>
					<a href="#graph" data-toggle="tab" onclick="refresh_chart();">Summary Graph</a>
				</li>
				<li>
					<a href="#discuss" data-toggle="tab">Discuss</a>
				</li>
			</ul>
			<div class="tab-content" style="padding:10px;background:white;border-bottom: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;">
				<div class="tab-pane  active" id="feedback" >
					<?php  
					foreach ($product_data['feedback_data'] as $root_key => $root_value )
					{
						if ($session->check()){ 
							$href = "#changeCategoryModal"; 
							$action = "category.change_name(\'"+root_value.category+"\');";
						} else { 
							$href= "#signInModal";
						}
							if ($root_value['thumbs_up']==null) $root_value['thumbs_up']=0;
							if ($root_value['thumbs_down']==null) $root_value['thumbs_down']=0;
							echo '<div>';
							echo '<p class="lead" id="'.(str_replace(' ', '',$root_value['category'])).'"><a class="btn btn-success" id="total-thumbsUp-'.$root_key.'">'.$root_value['thumbs_up'].'</a><a class="btn btn-danger" id="total-thumbsDown-'.$root_key.'" style="margin-right: 1em">'.$root_value['thumbs_down'].'</a>'.$root_value['category'].'<a href="#" onclick="CollapseEvent(this);return false;" class="btn btn-warning pull-right" data-toggle="collapse" data-target="#feedback'.$root_key.'"><i class="icon icon-white icon-chevron-down"></i></a></p>';
							echo '<div id="feedback'.$root_key.'" class="collapse" style="height: 0px;">';
							echo '<ul class="unstyled feedback" id="unstyled-feedback-'.$root_key.'">';
							foreach ($root_value['feedback'] as $key => $value)
							{
								$href = '';
								$action = '';
								if ($session->check()){$action = "like.add(".$value['feedback_id'].",".$root_key.");";} else { $href= "#signInModal";}
								if ($value['type']=="0"){ $style = 'class="text-success"'; } else { $style = 'class="text-warning"'; }
								echo '<li><p '.$style.' style="font-size: 1.2em"><a href="'.$href.'" data-toggle="modal" ><i onclick="'.$action.'" class="icon icon-chevron-up" style="opacity: 0.5"></i></a> <strong id="like-'.$value['feedback_id'].'">'.$value['total_likes'].'</strong> '.$value['comment'].'</p></li>';
							}
							echo '<div class="form-inline">';
							echo '<div class="btn-group" data-toggle="buttons-radio">';
							echo '<button type="button" onclick="feedback.addType('.$root_key.',0);return false;" style ="height: 30px;" class="btn thumbsUp"><i class="icon icon-thumbs-up"></i></button>';
							echo '<button type="button" onclick="feedback.addType('.$root_key.',1);return false;" style ="height: 30px;" class="btn thumbsDown"><i class="icon icon-thumbs-down"></i></button>';
							echo '<input type="hidden" id="add-feedback-type-'.$root_key.'" value="">';
							echo '</div>';
							echo '<input type="hidden" id="add-feedback-category-'.$root_key.'" value="'.$root_value['category'].'">';
							echo '<input type="text" class="input-xlarge" style="width: 63%;margin: 0 4px 0 4px;height: auto;" id="add-feedback-comment-'.$root_key.'" placeholder="Feedback">';
							if ($session->check()){
								echo '<a type="submit" onclick="feedback.save('.$root_key.');return false;" class="btn btn-primary"><i class="icon icon-white icon-plus-sign"></i> Add Feedback</a>';
							}else{
								echo '<a data-toggle="modal" href="#signInModal" type="submit" onclick="return false;" class="btn btn-primary"><i class="icon icon-white icon-plus-sign"></i> Add Feedback</a>';
							}
							echo '</div>';
							echo '</div>';
							echo '</div>';
							
						}
						$n = time();
						echo '<form class="form-inline">';
						echo '<div class="btn-group" data-toggle="buttons-radio">';
						echo '<button type="button"  onclick="feedback.addType('.$n.',0);return false;" style ="height: 30px;" class="btn thumbsUp"><i class="icon icon-thumbs-up"></i></button>';
						echo '<button type="button"  onclick="feedback.addType('.$n.',1);return false;" style ="height: 30px;"class="btn thumbsDown"><i class="icon icon-thumbs-down"></i></button>';
						echo '<input type="hidden" id="add-feedback-type-'.$n.'" value="">';
						echo '</div>';
						echo '<input type="text" class="input-medium" placeholder="Category" id="add-feedback-category-'.$n.'" style="margin-left:3px;height: auto;">';
						echo '<input type="text" class="input-xlarge" style="width: 41%;margin-left:3px;height: auto;" id="add-feedback-comment-'.$n.'" placeholder="Feedback" >';
						if ($session->check()){
							echo '<a data-toggle="modal" href="#" class="btn btn-primary" onclick="feedback.save('.$n.',1);return false;" style="margin-left:3px;"><i class="icon icon-white icon-plus-sign" ></i> Add Feedback</a>';
						}else{
							echo '<a data-toggle="modal" href="#signInModal" class="btn btn-primary" onclick="return false;" style="margin-left:3px;"><i class="icon icon-white icon-plus-sign" ></i> Add Feedback</a>';
						}
						echo '</form>';
				?>
				</div>
				<div class="tab-pane" id="graph"></div>
				<div class="tab-pane" id="discuss">

					<ol id = "questionArea"></ol>
					<div class="input-append" style="margin-left: 18px;">
						<input class="span7" id="questionText" type="text" placeholder="Ask a question!">
						<a href="#" class="btn" onclick="return false;" type="button" id="addQuestionBtn" data-toggle="modal">+ Add</a>
					</div>
				</div>
			</div>
			</div>
			<hr>
			<h2>Highest Rated 
				
			</h2> 
			<hr>
			<ul class="thumbnails" id="highest-rated"></ul>

		</div>
		
		<?php include "template/compare_products_modal.php"; ?>
		
		<div class="span3">
			<div class="span3 affix" data-spy="affix" data-offset-top="0">
				<a href="#" onclick="facebookAPP.login(pageUrl,product_title);return false;" class="btn btn-facebook btn-half"><i class="icon icon-facebook">&nbsp;</i>  Share</a>
				<a href="#" onclick="twitterAPP.post(<?='\''.curPageURL().'\',\''.$product_data['title'].'\'';?>);" class="btn <?=($session->getValue("social_network_name")=="twitter" ? "btn-twitter" : "");?> btn-half"><i class="icon icon-twitter">&nbsp;</i>  Tweet</a>
				<p id="social-loading" style="display:none;padding: 5px;text-align: center;">
					<img src="<?=SITE_ROOT;?>/images/ajax-loader.gif">
				</p>
				<p id="social-msg" style="display:none;padding: 5px;text-align: center;">
					Posted on your timeline!
				</p>
				<hr>
				<a href="#summarizeFriend" class="btn btn-primary btn-block" data-toggle="modal">Summarize With Friends</a>
				<hr>
							
				<a href="#" class="btn btn-success btn-block" id="follow-product-btn" data-toggle="modal">Follow Product</a>
				<a href="#addToCompare" role="button" class="btn btn-info btn-block" data-toggle="modal">Add to Compare List</a>
				<a <?=($session->check() ? 'href="#" onclick="report.add();window.location.href=\'index.php\';"' : 'href="#signInModal" data-toggle="modal"' );?> class="btn btn-danger btn-block">Report This Product</a>
				<div class="buy_links" style="float:none;margin-top:5px;margin-bottom: 5px;">
					<a href="#" class="buy_link btn btn-amazon"><i class="icon icon-shopping-cart"></i> Amazon</a>
					<a href="#" class="buy_link btn btn-generic-buy"><i class="icon icon-shopping-cart"></i> Buy This</a>
				</div>
				<hr style="margin:0px;">
				<h3 style="text-align:center;margin:0px"><b>Similar Products</b></h3>
				<div class="similar-products">
				</div>
				
				
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

<?php ($session->check() ? include "template/logged_in/footer.php" : include "template/logged_out/footer.php" );?>

<script>
var toggleCompare = function() {
	var compareContain = $('.compare-container');
	compareContain.toggleClass('compared');

}
$('.compare-button').click(toggleCompare);
$('.back-button').click(toggleCompare);
if (!member_login) register.checkInput("#register-form");
if (((facebook)||(twitter))&&(!member_login)) {
	
	$('#registerModal').modal('show');
	$('#register-text').hide();
	
}
$("#product-title").fitText({ minFontSize: '15px', maxFontSize: '50px' });

render.homePage(3);
compare.set('<?=addslashes ($product_data['title']);?>');
</script>
</body>
</html>
