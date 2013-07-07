<?php
include "backend/session.class.php";		// Base Classes
include "backend/global.functions.php";		// Global Functions
$session 		= new Session();
$database 		= new Database();
$facebook 		= new Fb();
$twitter 		= new Tw();
$_GET			= $database->escape($_GET);

if (!isset($_GET['seo'])){ 
	Redirect("http://www.summarizit.com/index.php");
}else{
	$visited_member_data = $database->member->checkSeoTitle($_GET['seo']);
	$visited_member_data == false ? Redirect("index.php") : $_GET['id'] = $visited_member_data['member_id'];
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

$_GET['id'] == $member_data['member_id'] ? Redirect(SITE_ROOT."/profile.php?action=activity") : "";

$visited_member_data['info'] 						= $database->member_info->get($visited_member_data['member_id']);
$visited_member_data['activity'] 					= $database->member_activity->get($visited_member_data['member_id'],10);
$visited_member_data['notifications'] 				= $database->notifications->get($visited_member_data['member_id'],10);
$visited_member_data['points']['total'] 			= $database->point->getTotal($visited_member_data['member_id']);
$visited_member_data['points']['products_count'] 	= $database->point->getTotalProducts($visited_member_data['member_id']);
$visited_member_data['points']['data'] 				= $database->point->getByReason($visited_member_data['member_id']);

// ######################## Load CSS And Header Data
include "template/header.php";
include "template/advanced_search_modal.php";

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
echo "<script> var visited_member_id 	= ".($visited_member_data['info']['member_id'])."; </script>";
echo "<script> var facebook     		= ".($session->getValue("social_network_name")=="facebook" ? "true" : "false" )."; </script>";
echo "<script> var twitter      		= ".($session->getValue("social_network_name")=="twitter"  ? "true" : "false" )."; </script>";

echo "<script>var site_root 	= '".SITE_ROOT."'; </script>";
echo "<script>var s3_base_link 	= 'http://".S3_BUCKET."'; </script>";

	
?>
<div class="container" style="width:705px" id="main">
	<div class="row">
		<div class="span9">
			<section >
				<?php include "template/logged_out/member/visited_profile_image.php";?>
				<h1><?=$visited_member_data['info']["first_name"]." ".$visited_member_data['info']["last_name"];?></h1>
				<h3><?=$visited_member_data['info']["short_bio"];?></h3>
				<!--<h2><?=$visited_member_data['points']['total'];?> points / <?=$visited_member_data['points']['products_count'];?> products</h2>-->
				<div class="clearfix"></div>
				
			</section>
		<section class="activity_wrap" >
			<h2>Activity</h2>
			<hr>
			<?php include "template/logged_out/member/visited_profile_activity.php"; ?>
		</section>
		<!--
		<section  class="points_wrap" >
			<h2>Total points <?=$visited_member_data['points']['total'];?></h2>
			<hr>
			<?php include "template/logged_out/member/visited_profile_points.php"; ?>
		</section>
		-->
		<!--<section class="messages_wrap" >
			<h2>Messages</h2>
			<hr>
			<?php include "template/logged_out/member/visited_profile_message_system.php";?>
		</section>-->
			<hr>
			<h2>Products Added 
				
			</h2>
			<hr/></h2>
			<ul class="thumbnails" id="products-added">
			</ul>
		</div>
	</div>
</div>

<?php ($session->check() ? include "template/logged_in/footer.php" : include "template/logged_out/footer.php" );?>

<script>
if (!member_login) register.checkInput("#register-form");
if (((facebook)||(twitter))&&(!member_login)) {
	
	$('#registerModal').modal('show');
	$('#register-text').hide();
	
}
render.productsAdded(visited_member_id,3);

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
