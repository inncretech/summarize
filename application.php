<?php
include "backend/session.class.php";		// Base Classes
include "backend/global.functions.php";		// Global Functions
$session 		= new Session();
$database 		= new Database();
$facebook 		= new Fb();
$twitter 		= new Tw();

if (!$session->check()) Redirect('index.php');

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
echo "<script> var member_login = ".($session->check() 									   ? "true" : "false" )."; </script>";
echo "<script> var facebook     = ".($session->getValue("social_network_name")=="facebook" ? "true" : "false" )."; </script>";
echo "<script> var twitter      = ".($session->getValue("social_network_name")=="twitter"  ? "true" : "false" )."; </script>";

echo "<script>var site_root 	= '".SITE_ROOT."'; </script>";
echo "<script>var s3_base_link = 'http://".S3_BUCKET."'; </script>";

?>
<div class="container" id="main">
	<div class="span12">
	<div class="breadcrumb" style="padding-top: 15px;padding-bottom: 25px;">
	 <h1 style="padding-top: 15px;">Welcome, <?=$member_data['login'];?>!</h1>
	 You can create your own application that will allow you to have a forum discussion on any page of your site with just three steps and a few pushes of a button.<a  class="btn btn-success"  href="<?=SITE_ROOT."/application/demo/index.php?id=5";?>" style="margin-top:0px;margin-left: 5px;">Demo</a>
	</div>

	<div class="breadcrumb">
		<div id="myCarousel" data-interval="3000" class="carousel slide" style="text-align:center;margin:0px;">
		  <!-- Carousel items -->
		  <div class="carousel-inner">
			<div class="active item">
			<h2>Step 1</h2>
          <p>Register your application.</p>
		  <p><img style="padding-left: 30px;" src="images/register-icon.png"></p></div>
			<div class="item">
			<h2>Step 2</h2>
          <p>Get your application key.</p>
		  <p><img src="images/Key-icon.png"></p></div>
			<div class="item">
			<h2>Step 3</h2>
          <p>Copy the code to your page.</p>
		  <p><img src="images/copy-icon.png"></p></div>
		  </div>
		  <!-- Carousel nav -->
		  <a class="carousel-control left" href="#myCarousel" data-slide="prev" style="font-size: 50px;">&lsaquo;</a>
		  <a class="carousel-control right" href="#myCarousel" data-slide="next" style="font-size: 50px;">&rsaquo;</a>
		</div>
	</div>

	
	<div class="breadcrumb" id="app-form" style="text-align:center;padding: 10px;">
		<table style="width:100%"><tr><td style="width:30%">
		<input class="input-xlarge" style="margin:0px;margin-right:5px;width:95%" type="text"  id="site-name" placeholder="Site Name">
		</td><td style="width:50%">
		<input class="input-xlarge" type="text" style="margin:0px;margin-right:5px;margin-left:5px;width:95%" id="site-domain" placeholder="Domain">
		</td><td>

 
	
		<button  class="btn btn-primary btn-block"  id="create-application-btn" onclick="application.create();return false;" style="margin-top:0px;margin-left: 5px;">Get Key</button>
		</td></tr>
		</table>
			
	 </div>
	
	
		<textarea style="text-align:left;width: 98.5%;height: 120px;resize:none;overflow: hidden;" readonly>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://www.summarizit.com/application/js/porthole.js"></script>
<script type="text/javascript" src="http://www.summarizit.com/application/js/external.app.functions.js"></script>
<script>
	summarizit.load(APP_ID,THREAD_ID,CONTAINER_ID);
</script>
		</textarea>
	 
	
	 <?php
		$data = $database->application_id->getByMember($member_data['member_id']);
		echo "<table class='table table-bordered' style='width:100%;background:white;'><tr><th>Site Name</th><th>Aplication Key</th><th>Created At</th></tr>";
		foreach ($data as $item){
			echo "<tr><td >".$item['site_name']."</td><td>".$item['application_request_id']."</td><td >".$item['created_at']."</td></tr>";
		}
		echo "</table>";
	 ?>
	
	

  </div> 
</div>
	
<?php ($session->check() ? include "template/logged_in/footer.php" : include "template/logged_out/footer.php" );?>

<script>
if (!member_login) register.checkInput("#register-form");
if (((facebook)||(twitter))&&(!member_login)) {
	
	$('#registerModal').modal('show');
	$('#register-text').hide();
	
}
render.homePage();
</script>
</body>
</html>
