<?php
include "backend/session.class.php";
include "backend/global.functions.php";
$facebook 		= new Fb();
$database 		= new Database();

if(($facebook->check)&&(isset($_GET['facebook_sign_in']))){
	$session 			= new Session($_GET,$facebook->logoutUrl);
	$session->setValue("social_network_id",$facebook->data['id']);
	$tmp_member_data 	= $database->member->checkFacebook($facebook->data['id']);
	if ($tmp_member_data!=null){
		$tmp_member_data['info'] 		= $database->member_info->get($tmp_member_data['member_id']);
		$tmp_member_image_id    		= $database->member_image->get($tmp_member_data['member_id']);
		$tmp_member_data['image'] 		= $database->image_table->get($tmp_member_image_id);
		$session->sign_in($tmp_member_data);
		Redirect("index.php");
	}
}else{
	$session 	= new Session($_GET,null);
}

$member_data = $session->get();
$member_data['info'] 						= $database->member_info->get($member_data['member_id']);

$member_data['activity'] 					= $database->member_activity->get($member_data['member_id'],10);
$member_data['notifications'] 				= $database->notifications->get($member_data['member_id'],10);
$member_data['points']['total'] 			= $database->point->getTotal($member_data['member_id']);
$member_data['points']['products_count'] 	= $database->point->getTotalProducts($member_data['member_id']);
$member_data['points']['data'] 				= $database->point->getByReason($member_data['member_id']);


include "template/header.php";
echo "<script>var member_login = true; </script>";
echo "<script>var member_id    = ".$member_data['member_id']."; </script>";
include "template/logged_in/top_menu.php";
include "template/logged_in/add_product_modal.php";

if ($facebook->check) {
	echo "<script>var facebook = true;</script>";
}else{
	echo "<script>var facebook = false;</script>";
}
?>
	<div class="container" id="main">
      <div class="row">
        <div class="span9">
		<section id="settings">
          <?php 
			include "template/logged_in/member/profile_image.php"; 
		?>
		
          <h1 style="margin-top: 1em;"><?=$member_data['info']["first_name"]." ".$member_data['info']["last_name"];?></h1>
          <h2><?=$member_data['points']['total'];?> points / <?=$member_data['points']['products_count'];?> products</h2>
          <div class="clearfix"></div>
          <hr />
		  
          <?php include "template/logged_in/member/profile_data.php"; ?>
          </section>
		  <section id="activity" >
		  <?php include "template/logged_in/member/profile_activity.php"; ?>
		  </section>
		  <section id="notifications" >
		  <?php include "template/logged_in/member/profile_notification.php"; ?>
		  </section>
		  <section id="points" >
		  <?php include "template/logged_in/member/profile_points.php"; ?>
		  </section>
		  <section id="messages" >
		  <?php include "template/logged_in/member/profile_message_system.php";?>
		  </section>
		  <hr>
          <h2>Products You've Added <a href="#" class="btn btn-warning pull-right" href="products.html" onclick="render.productsAdded(member_id,18);return false;">View More <i class="icon-circle-arrow-right icon-white"></i></a></h2>
          <hr style="margin-top: -5px" />
          <ul class="thumbnails" id="products-added">
            
          </ul>

        </div>
		
        <div class="span3">
          <div class="span3" id="afix" data-spy="affix" >
            <a href="#addProduct" onclick="scrollTo('#addProduct');return false;" role="button" class="btn btn-primary btn-block" data-toggle="modal">Add Product <i class="icon-plus icon-white"></i></a>
            <a href="#settings" onclick="scrollTo('#settings');return false;" class="btn btn-link btn-block">Account Settings</a>
            <a href="#activity" onclick="scrollTo('#activity');return false;" class="btn btn-link btn-block">Activity</a>
            <a href="#notifications" onclick="scrollTo('#notifications');return false;" class="btn btn-link btn-block">Notifications</a>
            <a href="#points" onclick="scrollTo('#points');return false;" class="btn btn-link btn-block">Points</a>
			<a href="#messages" onclick="scrollTo('#messages');return false;" class="btn btn-link btn-block">Messages</a>
            <hr />
            <!--
            <ul class="unstyled well">
              <li><a href="#" class="btn btn-link ">Terms</a></li>
              <li><a href="#" class="btn btn-link ">Twitter</a></li>
              <li><a href="#" class="btn btn-link ">Contact</a></li>
              <li><a href="#" class="btn btn-link ">About</a></li>
              <li><a href="#" class="btn btn-link ">Support</a></li>
            </ul>
			-->
          </div>
        </div>
      </div>
    </div>

	
	
<?php
include "template/logged_in/footer.php";
if ($session->check()){}else{Redirect("index.php");}
?>
<script>
$('html, body').animate({scrollTop: $("#<?=$_GET['action']?>").offset().top-49}, 2000);
render.productsAdded(member_id,3);
</script>
</body>
</html>
