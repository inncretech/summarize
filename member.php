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

if (!isset($_GET['id'])) Redirect("index.php");

$member_data = $session->get(); 
if ($_GET['id'] == $member_data['member_id']) Redirect("profile.php");

$visited_member_data 			= $database->member->get($_GET['id']);

$visited_member_data['info'] 	= $database->member_info->get($visited_member_data['member_id']);
$visited_member_image_id     	= $database->member_image->get($visited_member_data['member_id']);

$visited_member_data['image'] 	= $database->image_table->get($visited_member_image_id);


$visited_member_data['activity'] 		= $database->member_activity->get($visited_member_data['member_id'],10);
$visited_member_data['notifications'] 	= $database->notifications->get($visited_member_data['member_id'],10);
$visited_member_data['points']['total'] 	= $database->point->getTotal($visited_member_data['member_id']);
$visited_member_data['points']['products_count'] 	= $database->point->getTotalProducts($visited_member_data['member_id']);
$visited_member_data['points']['data'] 		= $database->point->getByReason($visited_member_data['member_id']);



include "template/header.php";

if ($session->check()){
	echo "<script>var member_login = true; </script>";
	echo "<script>var visited_member_id    = ".$visited_member_data['member_id']."; </script>";
	include "template/logged_in/top_menu.php";
}else{
	echo "<script>var member_login = false; </script>";
	echo "<script>var visited_member_id    = ".$visited_member_data['member_id']."; </script>";
	include "template/logged_out/top_menu.php";
	include "template/logged_out/sign_in_modal.php";
	include "template/logged_out/register_modal.php";
}


if ($facebook->check) {
	echo "<script>var facebook = true;</script>";
}else{
	echo "<script>var facebook = false;</script>";
}
	
?>
<div class="container" style="width:705px" id="main">
      <div class="row">
        <div class="span9">
		<section id="settings">
          <?php 
			include "template/logged_out/member/visited_profile_image.php";
		?>
		
          <h1 style="margin-top: 1em;"><?=$visited_member_data['info']["first_name"]." ".$visited_member_data['info']["last_name"];?></h1>
          <h2><?=$visited_member_data['points']['total'];?> points / <?=$visited_member_data['points']['products_count'];?> products</h2>
          <div class="clearfix"></div>
          
		  <?php 
			include "template/logged_out/member/visited_profile_data.php";
		
		?>
          </section>
		  <section id="activity" >
		  <?php 
			include "template/logged_out/member/visited_profile_activity.php";
		?>
		  </section>
		  <section id="notifications" >
		  
		  </section>
		  <section id="points" >
		 <?php 
				include "template/logged_out/member/visited_profile_points.php"; 
			?>	
		  </section>
		  <section id="messages" >
		  <?php
				if ($session->check()){
					include "template/logged_out/member/visited_profile_message_system.php"; 
				}
			?>
		  </section>
		 <hr>
          <h2>Products You've Added <a href="#" class="btn btn-warning pull-right" href="products.html" onclick="render.productsAdded(visited_member_id,18);return false;">View More <i class="icon-circle-arrow-right icon-white"></i></a></h2>
          <hr style="margin-top: -5px" /></h2>

          <ul class="thumbnails" id="products-added">
            
          </ul>

        </div>

      </div>
    </div>

<?php
if ($session->check()){
	include "template/logged_in/footer.php";
}else{
	include "template/logged_out/footer.php";
}
?>
<script>
render.productsAdded(visited_member_id,3);

</script>
</body>
</html>
