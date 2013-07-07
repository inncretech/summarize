<?php
include "backend/session.class.php";		// Base Classes
include "backend/global.functions.php";		// Global Functions
$session 		= new Session();
$database 		= new Database();
$facebook 		= new Fb();
$twitter 		= new Tw();
$_GET			= $database->escape($_GET);
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
$member_data['survey'] 						= $database->survey->getByMember($member_data['member_id']);
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
	
		<h2 ><?=$member_data['info']["first_name"]." ".$member_data['info']["last_name"];?></h2>
		<h3 ><?=$member_data['info']["short_bio"];?></h3>
		<!--<h2><?=$member_data['points']['total'];?> points / <?=$member_data['points']['products_count'];?> products</h2>-->
		<div class="clearfix"></div>
		<hr>
		<ul class="nav nav-tabs" style=" margin-bottom: 0px; ">
		  <li class="active"><a href="#settings_wrap" data-toggle="tab">Settings</a></li>
		  <li><a id="activity" href="#activity_wrap" data-toggle="tab">Recent Activity</a></li>
		  <li><a id="notifications" href="#notifications_wrap" data-toggle="tab">Notifications</a></li>
		 
		</ul>

		<div class="tab-content thumbnail" style=" background-color: white; padding: 20px; ">
		<div  class="tab-pane active" id="settings_wrap">
			<h2>Account Settings <!--<a href="#" class="div_hide btn btn-link" onclick="return false;">Hide Section</a>--></h2>
			<hr>
			<?php include "template/logged_in/member/profile_data.php"; ?>
		</div>

		<div class="tab-pane" id="activity_wrap">
			<h2>Activity <!--<a href="#" class="div_hide btn btn-link" onclick="return false;">Hide Section</a>--></h2>
			<hr>
			<?php include "template/logged_in/member/profile_activity.php"; ?>
		</div>
						
		<div class="tab-pane" id="notifications_wrap">
			<h2>Notifications <!--<a href="#" class="div_hide btn btn-link" onclick="return false;">Hide Section</a>--></h2>
			<hr>
			<?php include "template/logged_in/member/profile_notification.php"; ?>
		</div>
		<!--
		<div  class="points_wrap" style="display:none;">
			<h2>Total points <?=$member_data['points']['total'];?><!--<a href="#" class="div_hide btn btn-link" onclick="return false;">Hide Section</a></h2>
			<hr>
			<?php include "template/logged_in/member/profile_points.php"; ?>
		</div>
		-->
		<div class="tab-pane" id="survey_wrap">
			<h2>Survey <!--<a href="#" class="div_hide btn btn-link" onclick="return false;">Hide Section</a>--></h2>
			<hr>
			<?php include "template/logged_in/member/profile_survey.php";?>
		</div>
		
		<div class="tab-pane" id="messages_wrap">
			<h2>Messages <!--<a href="#" class="div_hide btn btn-link" onclick="return false;">Hide Section</a>--></h2>
			<hr>
			<?php include "template/logged_in/member/profile_message_system.php";?>
		</div>
		</div>
		<h2>Products You've Added 
			
		</h2>
		<hr>
		<ul class="thumbnails" id="products-added"></ul>
	</div>

	<div class="span3">
		<!--
		<div class="span3" id="afix" data-spy="affix" >
			<a href="#addProduct"  role="button" class="btn btn-primary btn-block" data-toggle="modal">Add Product <i class="icon-plus icon-white"></i></a>
			<a href="#" onclick="goTo('.setting_wrap');return false;"  class="btn btn-block settings_btn">Account Settings</a>
			<a href="#" onclick="goTo('.activity_wrap');return false;" class="btn btn-block activity_btn">Activity</a>
			<a href="#" onclick="goTo('.notifications_wrap');return false;" class="btn btn-block notifications_btn">Notifications</a>
			<a href="#" onclick="goTo('.points_wrap');return false;" class="btn btn-block points_btn">Points</a>
			<a href="#" onclick="goTo('.survey_wrap');return false;" class="btn btn-block points_btn">Survey List</a>
			<a href="<?=SITE_ROOT."/create-survey.php";?>" onclick="" class="btn btn-block points_btn">Create Survey</a>
			<a href="#"  class="btn btn-block messages_btn">Messages</a>
			<hr>
		-->
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
<script type="text/javascript" src="<?=SITE_ROOT;?>/js/survey.functions.js"></script>
<script>
goTo("<?=$_GET['action']?>")
function goTo(value){
	  $('#'+value).tab('show');
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
<?php include "template/footer.php" ;?></body>
</html>
