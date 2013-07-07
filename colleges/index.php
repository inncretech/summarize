<?php
include "../backend/session.class.php";		// Base Classes
include "../backend/global.functions.php";		// Global Functions
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

$template['title'] 		 = 'Search';
$template['description'] = 'Search you favorite products.';

// ######################## Load CSS And Header Data
include "../template/header.php";
include "../template/advanced_search_modal.php";
include "../template/add_to_compare_modal.php";
// ######################## Add Template Items
if ($session->check()){
	include "../template/logged_in/top_menu.php";
	include "../template/logged_in/add_product_modal.php";
}else{
	include "../template/logged_out/top_menu.php";
	include "../template/logged_out/sign_in_modal.php";
	include "../template/logged_out/register_modal.php";
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
	
</div>
	
<?php ($session->check() ? include "../template/logged_in/footer.php" : include "../template/logged_out/footer.php" );?>

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

render.colleges('<?=$_GET['query'];?>');

</script>
<?php include "../template/footer.php" ;?></body>
</html>
