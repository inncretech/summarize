<?php
include "backend/session.class.php";		// Base Classes
include "backend/global.functions.php";		// Global Functions
$session 		= new Session();
$database 		= new Database();
$facebook 		= new Fb();
$twitter 		= new Tw();

$session->check() ? "" :  Redirect("index.php");

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

$member_data['info'] 						= $database->member_info->get($member_data['member_id']);
$member_data['activity'] 					= $database->member_activity->get($member_data['member_id'],10);
$member_data['notifications'] 				= $database->notifications->get($member_data['member_id'],10);
$member_data['points']['total'] 			= $database->point->getTotal($member_data['member_id']);
$member_data['points']['products_count'] 	= $database->point->getTotalProducts($member_data['member_id']);
$member_data['points']['data'] 				= $database->point->getByReason($member_data['member_id']);


// ######################## Load CSS And Header Data
include "template/header.php";

// ######################## Add Template Items

include "template/logged_in/top_menu.php";
include "template/logged_in/add_product_modal.php";


// ######################## Initialize JS Variables
echo "<script> var member_id    = ".$member_data['member_id']."; </script>";
echo "<script> var member_login = ".($session->check() 									   ? "true" : "false" )."; </script>";
echo "<script> var facebook     = ".($session->getValue("social_network_name")=="facebook" ? "true" : "false" )."; </script>";
echo "<script> var twitter      = ".($session->getValue("social_network_name")=="twitter"  ? "true" : "false" )."; </script>";

echo "<script>var site_root 	= '".SITE_ROOT."'; </script>";
echo "<script>var s3_base_link 	= 'http://".S3_BUCKET."'; </script>";

?>
<div class="container" id="main">
  <div class="row">
	<div class="span9">
		<?php include "template/logged_in/member/profile_image.php"; ?>
	
		<h1 style="margin-top: 1em;"><?=$member_data['info']["first_name"]." ".$member_data['info']["last_name"];?></h1>
		<h2><?=$member_data['points']['total'];?> points / <?=$member_data['points']['products_count'];?> products</h2>
		<div class="clearfix"></div>


		<section class="settings_wrap" >
			<h2>Account Settings <a href="#" class="section_hide btn btn-link" onclick="return false;">Hide Section</a></h2>
			<hr>
			<?php include "template/logged_in/member/profile_data.php"; ?>
		</section>

		<section class="activity_wrap" >
			<h2>Activity <a href="#" class="section_hide btn btn-link" onclick="return false;">Hide Section</a></h2>
			<hr>
			<?php include "template/logged_in/member/profile_activity.php"; ?>
		</section>
						
		<section class="notifications_wrap" >
			<h2>Notifications <a href="#" class="section_hide btn btn-link" onclick="return false;">Hide Section</a></h2>
			<hr>
			<?php include "template/logged_in/member/profile_notification.php"; ?>
		</section>

		<section  class="points_wrap" >
			<h2>Total points <?=$member_data['points']['total'];?><a href="#" class="section_hide btn btn-link" onclick="return false;">Hide Section</a></h2>
			<hr>
			<?php include "template/logged_in/member/profile_points.php"; ?>
		</section>

		<!--<section class="messages_wrap" style="display:none;">
			<h2>Messages <a href="#" class="section_hide btn btn-link" onclick="return false;">Hide Section</a></h2>
			<hr>
			<?php include "template/logged_in/member/profile_message_system.php";?>
		</section>-->

		<h2>Products You've Added 
			<a href="#" class="btn btn-warning pull-right" href="products.html" onclick="render.productsAdded(member_id,18);return false;">View More 
				<i class="icon-circle-arrow-right icon-white"></i>
			</a>
		</h2>
		<hr>
		<ul class="thumbnails" id="products-added"></ul>
	</div>

	<div class="span3">
		<div class="span3" id="afix" data-spy="affix" >
			<a href="#addProduct"  role="button" class="btn btn-primary btn-block" data-toggle="modal">Add Product <i class="icon-plus icon-white"></i></a>
			<a href="#" onclick="goTo('.setting_wrap');return false;"  class="btn btn-block settings_btn">Account Settings</a>
			<a href="#" onclick="goTo('.activity_wrap');return false;" class="btn btn-block activity_btn">Activity</a>
			<a href="#" onclick="goTo('.notifications_wrap');return false;" class="btn btn-block notifications_btn">Notifications</a>
			<a href="#" onclick="goTo('.points_wrap');return false;" class="btn btn-block points_btn">Points</a>
			<!--<a href="#"  class="btn btn-block messages_btn">Messages</a>-->
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
  </div>
</div>

<?php include "template/logged_in/footer.php"; ?>

<script>
goTo(".<?=$_GET['action']?>_wrap")
function goTo(value){

	var pos = $(value).offset();
	$('body').animate({ scrollTop: pos.top-75 });
}


render.productsAdded(member_id,3);
/*
var toggleSection = function(section) {
	$(section + '_btn').click(function() {
		$(section +'_wrap').slideToggle('fast');
		return false;
	});
};
toggleSection('.settings');
toggleSection('.notifications');
toggleSection('.messages');
toggleSection('.points');
toggleSection('.activity');
*/
$('.notification .remove').click(function() {
	
	var parent = $(this).parent();
	parent.fadeOut('fast');
	return false;
});

$('.message').hover(function() {
	$(this).children('.message_actions').toggleClass('active');
});
$('.section_hide').click(function(){
	$(this).closest('section').slideToggle();
});
</script>
</body>
</html>
