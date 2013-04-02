<?php
include "backend/session.class.php";		// Base Classes
include "backend/global.functions.php";		// Global Functions
$session 		= new Session();
$database 		= new Database();
$facebook 		= new Fb();
$twitter 		= new Tw();


($session->check()  ? '' : Redirect(SITE_ROOT));

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

include "template/logged_in/top_menu.php";
include "template/logged_in/add_product_modal.php";


// ######################## Initialize JS Variables
echo "<script> var member_login 		= true; </script>";
echo "<script> var facebook     		= ".($session->getValue("social_network_name")=="facebook" ? "true" : "false" )."; </script>";
echo "<script> var twitter      		= ".($session->getValue("social_network_name")=="twitter"  ? "true" : "false" )."; </script>";
echo "<script> var site_root 			= '".SITE_ROOT."'; </script>";
echo "<script> var s3_base_link 		= 'http://".S3_BUCKET."'; </script>";
echo "<script> var similar_base_product = 1; </script>";
echo "<script> var compareItems 		= true; </script>";

$survey_id = 1;

?>
<div class="container" id="main">
	<div class="row">
	<div class="span9">
        <div class="hero-unit">
			<p style="margin:0px;">This feature allows you to create surveys with three types of answers checkbox, radio button or textbox in a simple and friendly way.</p>
		</div>
		<div class="alert alert-danger" id="survey-error" style="display:none;">
		<strong>Ups!</strong>
		Please fill all forms to be able to create the survey.
		</div>
		<form id="survey-create-form" method="POST" action="<?=SITE_ROOT?>/backend/ajax.post/add_survey.php">
			<input type="text" placeholder="Title" id="title" name="title" class="span9">
			<div id="survey-question">
			</div>
			<hr>
			<button onclick="survey.checkForm();return false;" id="create-survey-btn" class="btn btn-primary">Create</button>
			<button onclick="survey.addQuestion();return false;" id="add-survey-question" class="btn">Add question</button>
		</form>
	</div>
	<?php include "template/compare_products_modal.php"; ?>

	
	<div class="span3">
		<div data-spy="affix" data-offset-top="0" class="affix">
			
				<a href="#addProduct" role="button" class="btn btn-primary btn-block" data-toggle="modal">Add Product 
					<i class="icon-plus icon-white"></i>
				</a>
			
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
	</div>
</div>
	
<?php include "template/logged_out/footer.php";?>
<script type="text/javascript" src="<?=SITE_ROOT;?>/js/survey.functions.js"></script>
<script>
var toggleCompare = function() {
	var compareContain = $('.compare-container');
	compareContain.toggleClass('compared');

}
$('.compare-button').click(toggleCompare);
$('.back-button').click(toggleCompare);

compare.refresh_list();

</script>
</body>
</html>
