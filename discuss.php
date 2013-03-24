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
	<div class="hero-unit" style="padding-top: 15px;padding-bottom: 25px;">
	 <h1 style="padding-top: 15px;">Welcome, <?=$member_data['login'];?>!</h1>
	 On this page you can create your own application that will allow you to have a forum discussion on any page of your site with just three steps and a few pushes of a button.
	</div>


      <!-- Example row of columns -->
      <div class="row" style="text-align:center">
        <div class="span4">
          <h2>Step 1</h2>
          <p>Register your application.</p>
		  <p><img style="padding-left: 30px;" src="images/register-icon.png"></p>
          
        </div>
        <div class="span4">
          <h2>Step 2</h2>
          <p>Get your application key.</p>
		  <p><img src="images/Key-icon.png"></p>
       </div>
        <div class="span4">
          <h2>Step 3</h2>
          <p>Copy the code to your page.</p>
		  <p><img src="images/copy-icon.png"></p>
        </div>
      </div>
	
	<div class="hero-unit" id="app-form" style="text-align:center;padding-top: 15px;padding-bottom: 25px;min-height: 15px;">
		<table style="margin-left:auto;margin-right:auto;"><tr><td>
		<input class="input-xlarge" style="margin:0px;" type="text"  id="site-name" placeholder="Site Name">
		</td><td>
		<input class="input-xlarge" type="text" style="margin:0px;margin-left:5px;" id="site-domain" placeholder="Domain">
		</td><td>

 
	
		<button  class="btn btn-primary"  id="create-application-btn" onclick="application.create();return false;" style="margin-top:0px;margin-left: 5px;">Create</button>
		</td></tr>
		</table>
			
	 </div>
	 <div class="hero-unit"  style="text-align:center;padding-top: 15px;padding-bottom: 25px;min-height: 15px;">
		Note! that you will require jQuery on your page for our script to work.
		<textarea style="text-align:left;width: 700px;height: 140px;resize:none;">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script src="http://www.summarizit.com/application/js/external.app.functions.js"></script>
<script src="http://www.summarizit.com/application/js/easyXDM.js"></script>
<script>
	summarizit.load(APP_ID,THREAD_ID,CONTAINER);
</script>
		</textarea>
	 </div>
	 <div class="hero-unit"  style="text-align:center;padding-top: 15px;padding-bottom: 25px;min-height: 15px;">
	 <?php
		$data = $database->application_id->getByMember($member_data['member_id']);
		echo "<table style='margin-left:auto;margin-right:auto;width:700px'><tr><th>Site Name</th><th>APP TOKEN</th></tr>";
		foreach ($data as $item){
			echo "<tr><td >".$item['site_name']."</td><td>".$item['application_request_id']."</td></tr>";
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
