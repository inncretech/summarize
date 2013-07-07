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

$template['title'] 		 = 'Highest Rated Products';
$template['description'] = 'Here you can find the highest rated products on our site.';

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
	<?=!$session->check() ? '<div class="span12">' : '<div class="span9" >';?>
	<?=($_GET['msg']=="survey" ? '<div class="alert alert-success" id="sign-in-info" style="margin-bottom: 10px;"><strong>Thank you!</strong> With this information we will improve your experience on our site in the future.</div>' : '');?>
			
			<ul class="breadcrumb">
			  <li><a href="<?=SITE_ROOT."/highest-rated.php"?>">Highest Rated</a> <span class="divider">/</span></li>
			  <li><a href="<?=SITE_ROOT."/most-viewed.php"?>">Most Viewed</a> <span class="divider">/</span></li>
			  <li><a href="<?=SITE_ROOT."/recently-added.php"?>">Recently Added</a></li>
			</ul>
			<h2>Highest Rated 
				
			</h2>
			<hr>
			<ul class="thumbnails" id="highest-rated">
				<?php
				$values 	= $database->product_feedback->getHighestRated(0,16);
				$data  		= Array();
				foreach ($values as $item){
					$tmp = $database->product->get($item['product_id']);
					
					array_push($data,$tmp);
				}
				$count = count($data);
				for ($i = 0; $i <$count; $i++) {

					$data[$i]['seo_title']  =  $database->product->getSeoTitle($data[$i]['product_id']);
					$data[$i]['likes'] 		=  $database->product_feedback->getRateDataTotal($data[$i]['product_id'],0);
					$data[$i]['dislikes'] 	=  $database->product_feedback->getRateDataTotal($data[$i]['product_id'],1);
					$product_image_id 		=  $database->product_image->get($data[$i]['product_id']);
					$data[$i]['top_feedback']	=  $database->product_feedback->getTopFeedback($data[$i]['product_id']);
					$data[$i]['image'] 		=  $database->image_table->get($product_image_id);
				}
				
				foreach ($data as $item){
					echo "<li class='span3'>";
					echo  "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='".SITE_ROOT."/product/".$item['seo_title']."'\" onmouseover='render.showDesc(this);' >";
					echo  "<a href='#' class='thumb'>";
					echo  "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'><strong>".$item['top_feedback']['category']."</strong>".$item['top_feedback']['comment']."";
					echo  "</div>";
					echo  "<label class='thumbnail-image-holder' ><img title='".$item['title']."' alt='".$item['title']."' src='http://".S3_BUCKET.".s3.amazonaws.com/p_".$item['image']['full_image_url']."_normal.jpg' ></label>";
					echo  "</a>";
					echo  "<div class='caption' style=''>";
					echo  "<hr style='margin-top: 10px;margin-bottom: 15px;'><p>";
					echo  "<div class='btn-group'>";
					echo  "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-right:1px solid grey;'><strong>".$item['likes']."</strong><i style='margin-left:3px;color:#41bb19;font-size: 13px;' class='icon icon-thumbs-up'></i></button>";
					echo  "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-left:1px solid grey;'><strong>".$item['dislikes']."</strong><i style='margin-left:3px;color:#f50f43;font-size: 13px;' class='icon icon-thumbs-down'></i></button>";
					echo  "</div>";
					echo  "<a class='btn btn-small pull-right' style='padding-left:6px;padding-right:6px' href='".SITE_ROOT."/product/".$item['seo_title']."'>View Product</a>";
					echo  "</p><hr style='margin-top: 15px;margin-bottom: 15px;'>";
					echo  "<h3 id='product-title'>".$item['title']."</h3>";
					echo  "</div>";
					echo  "</div>";
					echo  "</li>";
				}
				?>
			</ul>
			
		</div>
		<?php include "template/compare_products_modal.php"; ?>
		<?php if ($session->check()){ ?>
		
		<div class="span3">
			<div data-spy="affix" data-offset-top="0" class="affix">
				
					
				<a href="#addToCompare" role="button" class="btn btn-info btn-block" data-toggle="modal">Compare Products</a>
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

render.HighestRated();

</script>
<?php include "template/footer.php" ;?></body>
</html>
