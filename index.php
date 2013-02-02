<?php
include "backend/session.class.php";
include "backend/global.functions.php";
$facebook 		= new Fb();
$database 		= new Database();
/*
// Php Code Cache START
$cacheFile = 'phpCache/index.html';
$cachetime = 4 * 60;
// Serve from the cache if it is younger than $cachetime
if (file_exists($cacheFile) && time() - $cachetime < filemtime($cacheFile)) {
    include($cacheFile);
    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cacheFile))." -->\n";
    exit;
}else{
ob_start(); // Start the output buffer


//Php Code Cache END

// Cache the contents to a file
$cached = fopen($cacheFile, 'w') or die("Can not open file!");
fwrite($cached, ob_get_contents());
fclose($cached);
ob_end_flush(); // Send the output to the browser
}


*/
if(($facebook->check)&&(isset($_GET['facebook_sign_in']))){
	$session 			= new Session($_GET,$facebook->logoutUrl);
	$session->setValue("social_network_id",$facebook->data['id']);
	$tmp_member_data 	= $database->member->checkFacebook($facebook->data['id']);
	if ($tmp_member_data!=null){
		$tmp_member_data['info'] 		= $database->member_info->get($tmp_member_data['member_id']);
		$tmp_member_image_id    		= $database->member_image->get($tmp_member_data['member_id']);
		$tmp_member_data['image'] 		= $database->image_table->get($tmp_member_image_id);
		$session->sign_in($tmp_member_data);
		if ($session->getValue("next")!=""){
			Redirect($session->getValue("next"));
			$session->unsetValue("next");
		}else{
			Redirect("index.php");
		}
	}
}else{
	$session 	= new Session($_GET,null);
}

$member_data 	= $session->get();


include "template/header.php";
if ($session->check()){
	echo "<script>var member_login = true; </script>";
	include "template/logged_in/top_menu.php";
	include "template/logged_in/add_product_modal.php";
}else{
	echo "<script>var member_login = false; </script>";
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
	<?php if ($session->check()){ 
     echo '<div class="container" id="main">';
	 }else{
	 echo '<div class="container" style="width:705px" id="main">';
	 }
	 ?>
      <div class="row">
        <div class="span9">
          <h2>Highest Rated <a class="btn btn-warning pull-right" onclick="render.HighestRated();">View More <i class="icon-circle-arrow-right icon-white"></i></a></h2>
          <hr style="margin-top: -5px" />
          <ul class="thumbnails" id="highest-rated">
           
          </ul>
          <h2>Most Viewed <a class="btn btn-warning pull-right" onclick="render.MostViewed();">View More <i class="icon-circle-arrow-right icon-white"></i></a></h2>
          <hr style="margin-top: -5px" />
          <ul class="thumbnails" id="most-viewed">
           
          </ul>
          <h2>Recently Added <a class="btn btn-warning pull-right" onclick="render.RecentlyAdded();">View More <i class="icon-circle-arrow-right icon-white"></i></a></h2>
          <hr style="margin-top: -5px" />
          <ul class="thumbnails" id="recently-added">
            
          
        </div>
		<?php if ($session->check()){ ?>
         <div class="span3">
          <div data-spy="affix" data-offset-top="0">
            <h2> <a href="#addProduct" role="button" class="btn btn-primary btn-block" data-toggle="modal">Add Product <i class="icon-plus icon-white"></i></a></h2>
            <hr />
            <h3><strong>Created Products</strong></h3>
            <ul class="unstyled">
              <?php
				
				$member_products = $database->product->getRandomCreatedBy($member_data['member_id'],3);
				foreach ($member_products as $item){
					if (strlen($item['title'])>17) $item['title']=substr($item['title'],0,17)."...";
					echo '<li><a href="product.php?id='.$item['product_id'].'" class="btn btn-link ">'.$item['title'].' <i class="icon-circle-arrow-right"></i></a></li>';
				}
              
				?>
            </ul>
			<hr />
			<h3><strong>Followed Products</strong></h3>
            <ul class="unstyled">
              <?php
				
				$member_products = $database->product_follow->getRandomFollowedBy($member_data['member_id'],3);
				foreach ($member_products as $item){
					
					$data = $database->product->get($item['product_id']);
					if (strlen($data['title'])>17) $data['title']=substr($data['title'],0,17)."...";
					echo '<li><a href="product.php?id='.$data['product_id'].'" class="btn btn-link ">'.$data['title'].' <i class="icon-circle-arrow-right"></i></a></li>';
				}
              
				?>
            </ul>
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
		<?php } ?>
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
if ((facebook)&&(!member_login)) {
	register.checkInput("#register-form");
	$('#registerModal').modal('show');
}
render.homePage();
</script>
</body>
</html>
