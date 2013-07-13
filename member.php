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
$visited_member_data['follow']  					= $database->product_follow->getProducts($visited_member_data['member_id']);

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
<div class="container" id="main">
	<div class="row">
		<div class="span9">
			
				<?php include "template/logged_out/member/visited_profile_image.php";?>
				<h1><?=$visited_member_data['info']["first_name"]." ".$visited_member_data['info']["last_name"];?></h1>
				<h3><?=$visited_member_data['info']["short_bio"];?></h3>
				<!--<h2><?=$visited_member_data['points']['total'];?> points / <?=$visited_member_data['points']['products_count'];?> products</h2>-->
				<div class="clearfix"></div>
			
			<br>
			<ul class="nav nav-tabs" style=" margin-bottom: 0px; ">
		  <li class="active"><a href="#activity_wrap" data-toggle="tab">Recent Activity</a></li>
		 <li ><a href="#follow_wrap" data-toggle="tab">Products Followed</a></li>
		</ul>
		<div class="tab-content thumbnail" style=" background-color: white; padding: 20px; ">
		<div class="tab-pane active " style="background-color:white;" id="activity_wrap">
			<?php include "template/logged_out/member/visited_profile_activity.php"; ?>
		</div>
		<div class="tab-pane  " style="background-color:white;" id="follow_wrap">
			<?php include "template/logged_out/member/visited_profile_follow.php"; ?>
		</div>
		</div>
		
		
		
			<h2>Products Added 
				
			</h2>
			
			<ul class="thumbnails" id="products-added">
			</ul>
			<div id="products-added-info"></div>
			
		</div>
		<div class="span3">
		<div class=" afix-div">
  <div class="thumbnail" style="background-color:white;overflow:hidden;margin-bottom:20px;width:220px;">
  
 <span class="lead" style=""><strong>Top Trending</strong></span><br>
				<?php
					$tags = $database->product_tag->getMostUsedTags(20);
					$data = $database->tag->getMultiple($tags);

					foreach ($data as $item){
						if ($item != ''){
						echo '<a href="search.php?query='.urlencode($item).'"><span id="custom-tag" style="white-space: nowrap;overflow: hidden;max-width: 100px;text-overflow: ellipsis;">'.$item.'</span></a>';
						}
					}
				?>
			</div>
			
			<div class="thumbnail" style="background-color:white;overflow:hidden;width:220px;">
			<span class="lead" style=""><strong>Top Reviewers</strong></span><br>
				<?php
					$members = $database->product_feedback->getTopReviewers(15);
					$data = $database->member->getMultiple($members);
					
					foreach ($data as $item){
						if ($item != ''){
						echo '<a href="'.SITE_ROOT.'/member/'.$item['seo_title'].'"><span id="custom-tag-green"  style="white-space: nowrap;overflow: hidden;max-width: 100px;text-overflow: ellipsis;">'.$item['login'].'</span></a>';
						}
					}
				?>
			</div>
			</div>
  </div></div>
	
</div>

<?php ($session->check() ? include "template/logged_in/footer.php" : include "template/logged_out/footer.php" );?>

<script>
$('.afix-div').affix()
if (!member_login) register.checkInput("#register-form");
if (((facebook)||(twitter))&&(!member_login)) {
	
	$('#registerModal').modal('show');
	$('#register-text').hide();
	
}
var pa_limit = 3;
function morePa(){
	pa_limit += 9;
	render.productsAdded(visited_member_id,pa_limit);
}
render.productsAdded(visited_member_id,pa_limit);

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
