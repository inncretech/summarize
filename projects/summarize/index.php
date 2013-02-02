<?php
require_once "backend/session.class.php";
$session 	= new Session();
$database 	= new Database();
$member_data = $session->get();

require_once "template/header.php";
if ($session->check()){
	echo "<script>var member_login = true; </script>";
	require_once "template/logged_in/top_menu.php";
}else{
	echo "<script>var member_login = false; </script>";
	require_once "template/logged_out/top_menu.php";
	require_once "template/logged_out/sign_in_modal.php";
	require_once "template/logged_out/register_modal.php";
}
?>
	<?php if ($session->check()){ 
     echo '<div class="container">';
	 }else{
	 echo '<div class="container" style="width:870px">';
	 }
	 ?>
      <div class="row">
        <div class="span9">
          <h2>Highest Rated <a class="btn btn-warning pull-right">View More <i class="icon-circle-arrow-right icon-white"></i></a></h2>
          <hr style="margin-top: -5px" />
          <ul class="thumbnails" id="highest-rated">
           
          </ul>
          <h2>Most Viewed <a class="btn btn-warning pull-right">View More <i class="icon-circle-arrow-right icon-white"></i></a></h2>
          <hr style="margin-top: -5px" />
          <ul class="thumbnails" id="most-viewed">
           
          </ul>
          <h2>Recently Added <a class="btn btn-warning pull-right">View More <i class="icon-circle-arrow-right icon-white"></i></a></h2>
          <hr style="margin-top: -5px" />
          <ul class="thumbnails" id="recently-added">
            
          
        </div>
		<?php if ($session->check()){ ?>
        <div class="span3">
          <div data-spy="affix" data-offset-top="0">
            <h2><a href="add-product.php" class="btn btn-primary btn-block">Add Product <i class="icon-plus icon-white"></i></a></h2>
            <hr />
           <div class="unstyled well" style="width: 217px;text-align:center;">
		<ul class="unstyled">
				<li><h4><strong>Created Products</strong></h4></li>
				<?php
				
				$member_products = $database->product->getRandomCreatedBy($member_data['member_id'],3);
				foreach ($member_products as $item){
					echo '<li><a href="product.php?id='.$item['product_id'].'" class="btn btn-link ">'.$item['title'].' <i class="icon-circle-arrow-right"></i></a></li>';
				}
              
				?>
				<li><h4><strong>Followed Products</strong></h4></li>      
				<?php
				
				$member_products = $database->product_follow->getRandomFollowedBy($member_data['member_id'],3);
				foreach ($member_products as $item){
					$data = $database->product->get($item['product_id']);
					echo '<li><a href="product.php?id='.$data['product_id'].'" class="btn btn-link ">'.$data['title'].' <i class="icon-circle-arrow-right"></i></a></li>';
				}
              
				?>
            </ul>
			</div>
            <hr />
            <ul class="unstyled well">
              <li><a href="#" class="btn btn-link ">Terms</a></li>
              <li><a href="#" class="btn btn-link ">Twitter</a></li>
              <li><a href="#" class="btn btn-link ">Contact</a></li>
              <li><a href="#" class="btn btn-link ">About</a></li>
              <li><a href="#" class="btn btn-link ">Support</a></li>
            </ul>
          </div>
        </div>
		<?php } ?>
      </div>
    </div>
<?php
if ($session->check()){
	require_once "template/logged_in/footer.php";
}else{
	require_once "template/logged_out/footer.php";
}
?>
<script>
render.homePage();
</script>
</body>
</html>
