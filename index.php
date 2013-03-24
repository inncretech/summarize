<?php
include "backend/session.class.php";		// Base Classes
include "backend/global.functions.php";		// Global Functions
$session 		= new Session();
$database 		= new Database();
$facebook 		= new Fb();
$twitter 		= new Tw();

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

// ######################## Load CSS And Header Data
include "template/header.php";
include "template/advanced_search_modal.php";
include "template/add_to_compare_modal.php";
// ######################## Add Template Items
if ($session->check()){
	include "template/logged_in/top_menu.php";
	include "template/logged_in/add_product_modal.php";
}else{
	include "template/logged_out/top_menu.php";
	include "template/logged_out/sign_in_modal.php";
	include "template/logged_out/register_modal.php";
}

// ######################## Initialize JS Variables
echo "<script> var member_login 		= ".($session->check() 									   ? "true" : "false" )."; </script>";
echo "<script> var facebook     		= ".($session->getValue("social_network_name")=="facebook" ? "true" : "false" )."; </script>";
echo "<script> var twitter      		= ".($session->getValue("social_network_name")=="twitter"  ? "true" : "false" )."; </script>";
echo "<script> var similar_base_product = 1;</script>";
echo "<script> var compareItems 		= true; </script>";
echo "<script> var site_root 			= '".SITE_ROOT."'; </script>";
echo "<script> var s3_base_link 		= 'http://".S3_BUCKET."'; </script>";
echo "<script> var product_id; </script>";
?>
<div class="container" id="main">
	<div class="row">
	<?=!$session->check() ? '<div class="span12">' : '<div class="span9">';?>
	<?=($_GET['msg']=="survey" ? '<div class="alert alert-success" id="sign-in-info" style="margin-bottom: 10px;"><strong>Thank you!</strong> With this information we will improve your experience on our site in the future.</div>' : '');?>
	<div id="latest-feedback-add-form" style="margin-bottom:10px;text-align: center;">
	</div>
	<div class="alert alert-success" id="opinion-success" style="display:none">
	<strong>Yeey!</strong> Thank you for adding your opinion.
	</div>
	
	<hr>
	<div class="hero-unit" id="latest-feedback" style="display:none;padding:5px;margin-bottom:10px;text-align: left;">
	</div>
	<?php if (!$session->check()){ ?>
		<!--
		<div class="hero-unit">
        <h1>Hello!</h1>
        <p>We are SummarizIt.com. We specialize in helping you find and decide upon your desired items fast and easy using user friendly features. </p>
		<p>
			<a href="#addToCompare" role="button" class="btn btn-info btn-large" data-toggle="modal">Compare Products</a>
			<a href="#advancedSearchModal" role="button" class="btn btn-primary btn-large" data-toggle="modal" style="margin-left:5px;">Advanced Search</a>
			<a href="<?=SITE_ROOT?>/survey.php" role="button" class="btn btn-success btn-large" >Take Survey</a>
		</p>
        </div>
		-->
	<?php } ?>
			
			<h2>Highest Rated 
				
			</h2>
			<hr>
			<ul class="thumbnails" id="highest-rated">
				<!-- Container for first 3 most Highest Rated products -->
			</ul>
			<h2>Most Viewed 
				
			</h2>
			<hr>
			<ul class="thumbnails" id="most-viewed">
				<!-- Container for first 3 Most Viewed products -->
			</ul>
			<h2>Recently Added 
				
			</h2>
			<hr>
			<ul class="thumbnails" id="recently-added">
				<!-- Container for first 3 Recently Added products -->
			</ul>
		</div>
		<?php include "template/compare_products_modal.php"; ?>
		<?php if ($session->check()){ ?>
		
		<div class="span3">
			<div data-spy="affix" data-offset-top="0" class="affix">
				
					
				<a href="#addToCompare" role="button" class="btn btn-info btn-block" data-toggle="modal">Compare Products</a>
				<a href="<?=SITE_ROOT?>/survey.php" role="button" class="btn btn-block" >Take Survey</a>
				<h3><strong>Created Products</strong></h3>
				<ul class="unstyled">
					<?php
					$member_products = $database->product->getRandomCreatedBy($member_data['member_id'],3);
					foreach ($member_products as $item){
						(strlen($item['title'])>17 ? $item['title']=substr($item['title'],0,17)."..." : '');
						echo '<li>';
						echo '<a href="'.SITE_ROOT."/product/".$item['seo_title'].'" class="btn btn-link ">'.$item['title']; 
						echo '<i class="icon-circle-arrow-right"></i>';
						echo '</a>';
						echo '</li>';
					}
					?>
				</ul>
				<hr>
				<h3><strong>Followed Products</strong></h3>
				<ul class="unstyled">
					<?php
					$member_products = $database->product_follow->getRandomFollowedBy($member_data['member_id'],3);
					foreach ($member_products as $item){	
						$data = $database->product->get($item['product_id']);
						(strlen($data['title'])>17 ? $data['title']=substr($data['title'],0,17)."..." : '');
						echo '<li>';
						echo '<a href="'.SITE_ROOT."/product/".$data['seo_title'].'" class="btn btn-link ">'.$data['title']; 
						echo '<i class="icon-circle-arrow-right"></i>';
						echo '</a>';
						echo '</li>';
					}
					?>
				</ul>
				<hr>
				<ul class="unstyled well">
				  <li><a href="#" class="btn btn-link ">Terms</a></li>
				  <li><a href="#" class="btn btn-link ">Twitter</a></li>
				  <li><a href="#" class="btn btn-link ">Contact</a></li>
				  <li><a href="#" class="btn btn-link ">About</a></li>
				  <li><a href="#" class="btn btn-link ">Support</a></li>
				</ul>
			</div>
		</div>
		<?php } ?>
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

compare.refresh_list();
if (!member_login) {
	register.checkInput("#register-form");
}
if (((facebook)||(twitter))&&(!member_login)) {
	
	$('#registerModal').modal('show');
	$('#register-text').hide();
	
}
setInterval(function(){render.latestFeedback();},1000);

if (member_login) {
	render.latestFeedbackAddForm();
	render.homePage(3);
}else render.homePage(4);
render.latestFeedback();
</script>
</body>
</html>
