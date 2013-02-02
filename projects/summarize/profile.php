<?php
require_once "backend/constants.php";
require_once "backend/session.class.php";
require_once "backend/global.functions.php";

$session 	= new Session();
$database 	= new Database();

$member_data = $session->get();
$member_data['activity'] 			= $database->member_activity->get($member_data['member_id'],10);
$member_data['notifications'] 		= $database->notifications->get($member_data['member_id'],10);
$member_data['points']['total'] 	= $database->point->getTotal($member_data['member_id']);
$member_data['points']['data'] 		= $database->point->getByReason($member_data['member_id']);

require_once "template/header.php";
echo "<script>var member_login = true; </script>";
require_once "template/logged_in/top_menu.php";

	
?>
	
<div class="container" style="margin-bottom:100px;">

    <!-- Docs nav
    ================================================== -->
    <div class="row">
      <div class="span3 bs-docs-sidebar">
	
		<?php 
			require_once "template/logged_in/member/profile_image.php"; 
		?>
        <ul class="nav nav-list bs-docs-sidenav affix-top">
          <li><a href="#settings"><i class="icon-chevron-right"></i> Settings</a></li>
          <li><a href="#activity"><i class="icon-chevron-right"></i> Activity</a></li>		  
          <li><a href="#notifications"><i class="icon-chevron-right"></i> Notifications</a></li>
          <li><a href="#points"><i class="icon-chevron-right"></i> Points</a></li>
          <li><a href="#messages"><i class="icon-chevron-right"></i> Messages</a></li>
        </ul>
		
		<div class="unstyled well" style="position:fixed;margin-top: 20px;width: 217px;text-align:center;">
			
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
      </div>
	  
      <div class="span9">


        <!-- Settings
        ================================================== -->
        <section id="settings">	
        <?php require_once "template/logged_in/member/profile_data.php"; ?>
        </section>



        <!-- Transitions
        ================================================== -->
        <section id="activity">
		
		<?php 
			
				require_once "template/logged_in/member/profile_activity.php"; 
		
		?>
          
        </section>



        <!-- Notifications
        ================================================== -->
        <section id="notifications">
         
		 <?php 
				require_once "template/logged_in/member/profile_notification.php"; 
		?>
		 
        </section>



        <!-- Points
        ================================================== -->
        <section id="points">
			<?php 
				require_once "template/logged_in/member/profile_points.php"; 
		?>	
        </section>



        <!-- Messages
        ================================================== -->
        <section id="messages">
			<?php
			
				require_once "template/logged_in/member/profile_message_system.php"; 

			?>
        </section>
      </div>
    </div>

  </div>
<?php
require_once "template/logged_in/footer.php";
if ($session->check()){}else{Redirect("index.php");}
?>
</body>
</html>
