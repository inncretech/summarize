<?php
include "backend/session.class.php";		// Base Classes
include "backend/global.functions.php";		// Global Functions
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

$template['title'] 		 = 'Home';
$template['description'] = 'We are SummarizIt.com. We specialize in helping you find and decide upon your desired items fast and easy using user friendly features.';

// ######################## Load CSS And Header Data
include "template/header.php";
include "template/advanced_search_modal.php";
include "template/add_to_compare_modal.php";
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
echo "<script> var facebook     		= ".($session->getValue("social_network_name")=="facebook" ? "true" : "false" )."; </script>";
echo "<script> var twitter      		= ".($session->getValue("social_network_name")=="twitter"  ? "true" : "false" )."; </script>";
echo "<script> var similar_base_product = 1;</script>";
echo "<script> var compareItems 		= true; </script>";
echo "<script> var site_root 			= '".SITE_ROOT."'; </script>";
echo "<script> var s3_base_link 		= 'http://".S3_BUCKET."'; </script>";
echo "<script> var product_id; </script>";
?>
<div class="container" id="main">
	<div class="row">
	<?=!$session->check() ? '<div class="span12">' : '<div class="span9" >';?>
	<?=($_GET['msg']=="survey" ? '<div class="alert alert-success" id="sign-in-info" style="margin-bottom: 10px;"><strong>Thank you!</strong> With this information we will improve your experience on our site in the future.</div>' : '');?>
	<!--
	<div id="latest-feedback-add-form" style="display:none;background:white;border: 1px solid rgb(226, 218, 218);margin-bottom:10px;text-align: center;padding:5px;">
	</div>
	<div class="alert alert-success" id="opinion-success" style="display:none">
	<strong>Yeey!</strong> Thank you for adding your opinion.
	</div>
	
	<div class="hero-unit" id="latest-feedback" style="display:none;padding:5px;margin-bottom:10px;text-align: left;">
	</div>
	-->
	<?php if (!$session->check()){ ?>
	
		<div class="row" >
		<div class="span3">

		</div>
		<div class="span6" style=" height: 650px;margin-top: -50px; ">
			<h2 style="font-weight:bold;color:white;position:relative;top:150px;text-align: center;">We Summ-It-Up!</h2>
			<div class="big-circle lead" style="padding:0px;width: 460px;height: 450px;">
			<p style=" padding-top: 200px; ">We make reading and sharing opinions<br> one of your easiest online hobbies.</p>
			<p style=" padding-top:0px; ">
			<a href="https://www.facebook.com/pages/Summarizit/579998852010425" style="color:#3b5998;"><strong>Facebook</strong></a> 
			<a href="https://twitter.com/Summarizit" style="color:#007fff"><strong>Twitter</strong></a>
			
			</div>
			<div class="small-circle grey-circle lead" style="top:-270px;left:-100px;">Products</div>
			<div class="small-circle purple-circle lead" style="top:-140px;left:-165px;">Restaurants</div>
			<div class="small-circle green-circle lead" style="top:-50px;left:-155px;">Colleges</div>
			<div class="small-circle yellow-circle lead" style="top:-190px;left:255px;">Books</div>
			<div class="small-circle blue-circle lead" style="top:-270px;left:260px;">Movies</div>
			<div class="small-circle violet-circle lead" style="top:-405px;left:200px;">Hotels</div>
		</div>
	<div class="span3">

		</div>
		
	</div>
	
	<div class="row" style="margin-bottom:40px;">
		
		<div class="thumbnails" style="margin-left:0px;">
		<div class="span4" style="margin-left:10px;">
			<p class="lead" style="color:#6071f3;text-align:center;margin: 5px;height: 70px;line-height: 70px;"><strong>Opinions Matter</strong></p>
			<div class="thumbnail" style="background-color:white;height:250px;">
				
					<img src="images/collage.jpg" style="margin-top:10px;width: 80%;padding-top: 28px;">
			</div>
		</div>
		<div class="span4" id="hwi-container">
		<p class="lead" style="color:#6071f3;text-align:center;margin: 10px;"><strong>Summarized Into <br>Easy-to-Read Reviews</strong></p>
		<div class="thumbnail" style="background-color:white;height:250px;">
			
			<div style="padding:7px;padding-top:15px;width: 200px;margin-left: auto;margin-right: auto;"><p class="lead" id="Design"><a class="btn btn-success pull-left" id="total-thumbsUp-0">21</a><a class="btn btn-danger pull-left" id="total-thumbsDown-0" style="margin-right: 1em">3</a>Design<a href="#" onclick="CollapseEvent(this);return false;" class="btn btn-info pull-left collapsed" style="margin-right:5px;"><i class="icon icon-white icon-chevron-down"></i></a></p><div id="feedback0"><ul class="unstyled feedback" id="unstyled-feedback-0"><li><p style="font-size: 1.2em;font-weight: 500;"><a href="#signInModal" data-toggle="modal"><i onclick="" class="icon icon-thumbs-up" style="opacity: 0.8;color:black;"></i></a><strong class="text-success" id="like-24">3</strong> Fancy Design.</p></li><li><p style="font-size: 1.2em;font-weight: 500;"><a href="#signInModal" data-toggle="modal"><i onclick="" class="icon icon-thumbs-up" style="opacity: 0.8;color:black;"></i></a><strong class="text-warning" id="like-33">3</strong> It's a bit wide.</p></li><li><p style="font-size: 1.2em;font-weight: 500;"><a href="#signInModal" data-toggle="modal"><i onclick="" class="icon icon-thumbs-up" style="opacity: 0.8;color:black;"></i></a><strong class="text-success" id="like-477">3</strong> Attractive design</p></li><li><p style="font-size: 1.2em;font-weight: 500;"><a href="#signInModal" data-toggle="modal"><i onclick="" class="icon icon-thumbs-up" style="opacity: 0.8;color:black;"></i></a><strong class="text-success" id="like-477">5</strong> Futuristic</p></li><li><p style="font-size: 1.2em;font-weight: 500;"><a href="#signInModal" data-toggle="modal"><i onclick="" class="icon icon-thumbs-up" style="opacity: 0.8;color:black;"></i></a><strong class="text-success" id="like-477">11</strong> Very nice looking</p></li></ul></div></div>
			</div>
		</div>
		<div class="span4">
		<p class="lead" style="color:#6071f3;text-align:center;margin: 10px;"><strong>Quickly Delivered Information</strong></p>
		<div class="thumbnail" style="background-color:white;height:250px;">
			
			<div style="text-align:center;">
				
				<img src="images/idea.png" style="height:200px;padding-top: 20px;">
			</div>
		</div>
		</div>
		
		</div>
		</div>
		
		<div class="row" style="margin-bottom:40px;">
		
		<div class="thumbnails" style="margin-left:0px;">
		<div class="span4" style="margin-left:10px;">
			<p class="lead" style="color:#6071f3;text-align:center;margin: 5px;height: 70px;line-height: 70px;"><strong>Top Trending</strong></p>
			<div class="thumbnail" style="background-color:white;height:233px;overflow:hidden">
				<?php
					$tags = $database->product_tag->getMostUsedTags(20);
					$data = $database->tag->getMultiple($tags);

					foreach ($data as $item){
						if ($item != ''){
						echo '<a href="search.php?query='.urlencode($item).'"><span id="custom-tag" style="white-space: nowrap;overflow: hidden;max-width: 80px;text-overflow: ellipsis;">'.$item.'</span></a>';
						}
					}
				?>
			</div>
		</div>
		<div class="span4" id="hwi-container">
		<p class="lead" style="color:#6071f3;text-align:center;margin: 5px;height: 70px;line-height: 70px;"><strong>Top Reviewers</strong></p>
		<div class="thumbnail" style="background-color:white;height:233px;overflow:hidden">
				<?php
					$members = $database->product_feedback->getTopReviewers(20);
					$data = $database->member->getMultiple($members);
					
					foreach ($data as $item){
						if ($item != ''){
						echo '<a href="'.SITE_ROOT.'/member/'.$item['seo_title'].'"><span style="margin:5px;background-color: #468847;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;display: inline-block;padding: 4px 4px;font-size: 11.844px;font-weight: bold;line-height: 14px;color: #ffffff;text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);white-space: nowrap;vertical-align: baseline;">'.$item['login'].'</span></a>';
						}
					}
				?>
			</div>
		</div>
		<div class="span4">
		<p class="lead" style="color:#6071f3;text-align:center;margin: 5px;height: 70px;line-height: 70px;"><strong>Top</strong></p>
		<div class="thumbnail" style="background-color:white;height:233px;">
			
		</div>
		</div>
		
		</div>
		</div>
			
			<div class="row" style="background-color:white;padding:20px;border:1px solid rgb(206, 206, 206);margin-bottom:40px;">
			<p class="lead1">Which experience do you prefer?</p>
			<div class="row well" style=" margin: 10px; margin-top: 20px; ">
			<div class="span3"><p class="lead2">At Other Websites</p>
			<p class="normal1">In my opinion this phone has a fancy design.Its weight is very light,but, unfortunately, the lightness of the phone makes it quite difficult to hold sometimes. It is also a very expensive phone to purchase without saving up a lot of hard-earned salary money. Moreover, I believe the price is far too high for the limited features that the phone offers. I would give this phone a thumbs up for design and weight, but a thumbs down for cost.</p>
			</div>
			<div class="span2"><img src="images/ClearParchmentSkeptical2.png" style="width:110px;"><img style="float:right;height:330px;margin-right:-20px;" src="images/line.png"></div>
			
			<div class="span5" style="float:right;">
			<p class="lead2">On Summariz<i>It</i></p>
			<img src="images/ClearSummitSnap2.png" style="width:150px;">
			<div style="background-color:white;padding:7px;width: 200px;float: right;"><p class="lead" id="Design"><a class="btn btn-success pull-left" id="total-thumbsUp-0">21</a><a class="btn btn-danger pull-left" id="total-thumbsDown-0" style="margin-right: 1em">3</a>Design<a href="#" onclick="CollapseEvent(this);return false;" class="btn btn-info pull-left collapsed" style="margin-right:5px;"><i class="icon icon-white icon-chevron-down"></i></a></p><div id="feedback0"><ul class="unstyled feedback" id="unstyled-feedback-0"><li><p style="font-size: 1.2em;font-weight: 500;"><a href="#signInModal" data-toggle="modal"><i onclick="" class="icon icon-thumbs-up" style="opacity: 0.8;color:black;"></i></a><strong class="text-success" id="like-24">3</strong> Fancy Design.</p></li><li><p style="font-size: 1.2em;font-weight: 500;"><a href="#signInModal" data-toggle="modal"><i onclick="" class="icon icon-thumbs-up" style="opacity: 0.8;color:black;"></i></a><strong class="text-warning" id="like-33">3</strong> It's a bit wide.</p></li><li><p style="font-size: 1.2em;font-weight: 500;"><a href="#signInModal" data-toggle="modal"><i onclick="" class="icon icon-thumbs-up" style="opacity: 0.8;color:black;"></i></a><strong class="text-success" id="like-477">3</strong> Attractive design</p></li><li><p style="font-size: 1.2em;font-weight: 500;"><a href="#signInModal" data-toggle="modal"><i onclick="" class="icon icon-thumbs-up" style="opacity: 0.8;color:black;"></i></a><strong class="text-success" id="like-477">5</strong> Futuristic</p></li><li><p style="font-size: 1.2em;font-weight: 500;"><a href="#signInModal" data-toggle="modal"><i onclick="" class="icon icon-thumbs-up" style="opacity: 0.8;color:black;"></i></a><strong class="text-success" id="like-477">11</strong> Very nice looking</p></li></ul></div></div>
			</div>
			</div>
		</div>
			
        </div>
		
	<?php } ?>
			
			<h2><a href="<?=SITE_ROOT."/highest-rated.php"?>" >Highest Rated </a>
				
			</h2>
			<hr>
			<ul class="thumbnails" id="highest-rated">
				<?php
				$values 	= $database->product_feedback->getHighestRated(0,($session->check() ? 3 : 4));
				$data  		= Array();
				foreach ($values as $item){
					$tmp = $database->product->get($item['product_id']);
					
					array_push($data,$tmp);
				}
				$count = count($data);
				for ($i = 0; $i <$count; $i++) {

					$data[$i]['seo_title']  =  $database->product->getSeoTitle($data[$i]['product_id']);
					$data[$i]['likes'] 		=  $database->product_feedback->getRateDataTotal($data[$i]['product_id'],0);
					$data[$i]['dislikes'] 	=  $database->product_feedback->getRateDataTotal($data[$i]['product_id'],1);
					$product_image_id 		=  $database->product_image->get($data[$i]['product_id']);
					$data[$i]['top_feedback']	=  $database->product_feedback->getTopFeedback($data[$i]['product_id']);
					$data[$i]['image'] 		=  $database->image_table->get($product_image_id);
				}
				
				foreach ($data as $item){
					echo "<li class='span3'>";
					echo  "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='".SITE_ROOT."/product/".$item['seo_title']."'\" onmouseover='render.showDesc(this);' >";
					echo  "<a href='#' class='thumb'>";
					echo  "<div class='overlay' style='opacity: 0.9;height: 215px;width:220px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'><strong>".$item['top_feedback']['category']."</strong>".$item['top_feedback']['comment']."";
					echo  "</div>";
					echo  "<label class='thumbnail-image-holder' ><img title='".$item['title']."' alt='".$item['title']."' src='http://".S3_BUCKET.".s3.amazonaws.com/p_".$item['image']['full_image_url']."_normal.jpg' ></label>";
					echo  "</a>";
					echo  "<div class='caption' style=''>";
					echo  "<hr style='margin-top: 10px;margin-bottom: 15px;'><p>";
					echo  "<div class='btn-group'>";
					echo  "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-right:1px solid grey;'><strong>".$item['likes']."</strong><i style='margin-left:3px;color:#41bb19;font-size: 13px;' class='icon icon-thumbs-up'></i></button>";
					echo  "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-left:1px solid grey;'><strong>".$item['dislikes']."</strong><i style='margin-left:3px;color:#f50f43;font-size: 13px;' class='icon icon-thumbs-down'></i></button>";
					echo  "</div>";
					echo  "<a class='btn btn-small pull-right' style='padding-left:6px;padding-right:6px' href='".SITE_ROOT."/product/".$item['seo_title']."'>View Product</a>";
					echo  "</p><hr style='margin-top: 15px;margin-bottom: 15px;'>";
					echo  "<h3 id='product-title'>".$item['title']."</h3>";
					echo  "</div>";
					echo  "</div>";
					echo  "</li>";
				}
				?>
			</ul>
			<h2><a href="<?=SITE_ROOT."/most-viewed.php"?>" >Most Viewed</a> 
				
			</h2>
			<hr>
			<ul class="thumbnails" id="most-viewed">
				<?php
				$values 	= $database->view_details->getMostViewed(0,($session->check() ? 3 : 4));

				$data  		= Array();
				foreach ($values as $item){
					$tmp = $database->product->get($item['viewed_product_id']);
					
					array_push($data,$tmp);
				}
				$count = count($data);
				for ($i = 0; $i <$count; $i++) {

					$data[$i]['seo_title']  =  $database->product->getSeoTitle($data[$i]['product_id']);
					$data[$i]['likes'] 		=  $database->product_feedback->getRateDataTotal($data[$i]['product_id'],0);
					$data[$i]['dislikes'] 	=  $database->product_feedback->getRateDataTotal($data[$i]['product_id'],1);
					$product_image_id 		=  $database->product_image->get($data[$i]['product_id']);
					$data[$i]['top_feedback']	=  $database->product_feedback->getTopFeedback($data[$i]['product_id']);
					$data[$i]['image'] 		=  $database->image_table->get($product_image_id);
				}
				
				foreach ($data as $item){
					echo "<li class='span3'>";
					echo  "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='".SITE_ROOT."/product/".$item['seo_title']."'\" onmouseover='render.showDesc(this);' >";
					echo  "<a href='#' class='thumb'>";
					echo  "<div class='overlay' style='opacity: 0.9;height: 215px;width:220px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'><strong>".$item['top_feedback']['category']."</strong>".$item['top_feedback']['comment']."";
					echo  "</div>";
					echo  "<label class='thumbnail-image-holder' ><img title='".$item['title']."' alt='".$item['title']."' src='http://".S3_BUCKET.".s3.amazonaws.com/p_".$item['image']['full_image_url']."_normal.jpg' ></label>";
					echo  "</a>";
					echo  "<div class='caption' style=''>";
					echo  "<hr style='margin-top: 10px;margin-bottom: 15px;'><p>";
					echo  "<div class='btn-group'>";
					echo  "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-right:1px solid grey;'><strong>".$item['likes']."</strong><i style='margin-left:3px;color:#41bb19;font-size: 13px;' class='icon icon-thumbs-up'></i></button>";
					echo  "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-left:1px solid grey;'><strong>".$item['dislikes']."</strong><i style='margin-left:3px;color:#f50f43;font-size: 13px;' class='icon icon-thumbs-down'></i></button>";
					echo  "</div>";
					echo  "<a class='btn btn-small pull-right' style='padding-left:6px;padding-right:6px' href='".SITE_ROOT."/product/".$item['seo_title']."'>View Product</a>";
					echo  "</p><hr style='margin-top: 15px;margin-bottom: 15px;'>";
					echo  "<h3 id='product-title'>".$item['title']."</h3>";
					echo  "</div>";
					echo  "</div>";
					echo  "</li>";
				}
				?>
			</ul>
			<h2><a href="<?=SITE_ROOT."/recently-added.php"?>" >Recently Added </a>
				
			</h2>
			<hr>
			<ul class="thumbnails" id="recently-added">
				<?php
				$data 		= $database->product->getRecentlyAdded(0,($session->check() ? 3 : 4));

				$count = count($data);
				for ($i = 0; $i <$count; $i++) {

					$data[$i]['seo_title']  =  $database->product->getSeoTitle($data[$i]['product_id']);
					$data[$i]['likes'] 		=  $database->product_feedback->getRateDataTotal($data[$i]['product_id'],0);
					$data[$i]['dislikes'] 	=  $database->product_feedback->getRateDataTotal($data[$i]['product_id'],1);
					$product_image_id 		=  $database->product_image->get($data[$i]['product_id']);
					$data[$i]['top_feedback']	=  $database->product_feedback->getTopFeedback($data[$i]['product_id']);
					$data[$i]['image'] 		=  $database->image_table->get($product_image_id);
				}
				
				foreach ($data as $item){
					echo "<li class='span3'>";
					echo  "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='".SITE_ROOT."/product/".$item['seo_title']."'\" onmouseover='render.showDesc(this);' >";
					echo  "<a href='#' class='thumb'>";
					echo  "<div class='overlay' style='opacity: 0.9;height: 215px;width:220px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'><strong>".$item['top_feedback']['category']."</strong>".$item['top_feedback']['comment']."";
					echo  "</div>";
					echo  "<label class='thumbnail-image-holder' ><img title='".$item['title']."' alt='".$item['title']."' src='http://".S3_BUCKET.".s3.amazonaws.com/p_".$item['image']['full_image_url']."_normal.jpg' ></label>";
					echo  "</a>";
					echo  "<div class='caption' style=''>";
					echo  "<hr style='margin-top: 10px;margin-bottom: 15px;'><p>";
					echo  "<div class='btn-group'>";
					echo  "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-right:1px solid grey;'><strong>".$item['likes']."</strong><i style='margin-left:3px;color:#41bb19;font-size: 13px;' class='icon icon-thumbs-up'></i></button>";
					echo  "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-left:1px solid grey;'><strong>".$item['dislikes']."</strong><i style='margin-left:3px;color:#f50f43;font-size: 13px;' class='icon icon-thumbs-down'></i></button>";
					echo  "</div>";
					echo  "<a class='btn btn-small pull-right' style='padding-left:6px;padding-right:6px' href='".SITE_ROOT."/product/".$item['seo_title']."'>View Product</a>";
					echo  "</p><hr style='margin-top: 15px;margin-bottom: 15px;'>";
					echo  "<h3 id='product-title'>".$item['title']."</h3>";
					echo  "</div>";
					echo  "</div>";
					echo  "</li>";
				}
				?>
			</ul>
		</div>
		<?php include "template/compare_products_modal.php"; ?>
		<?php if ($session->check()){ ?>
		
		<div class="span3">
			
				
					
				<a href="#addToCompare" role="button" class="btn btn-info btn-block" data-toggle="modal">Compare Products</a>
				
			  <br>
		
  <div class="thumbnail" style="background-color:white;overflow:hidden;margin-bottom:20px;">
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
			
			<div class="thumbnail" style="background-color:white;overflow:hidden">
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
  
				
				
				
				<!--<h3><strong>Created Products</strong></h3>
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
				</ul>-->
			</div>
		
		<?php } ?>
	</div>
</div>
	
<?php ($session->check() ? include "template/logged_in/footer.php" : include "template/logged_out/footer.php" );?>

<script>
$("#how-it-works-btn").click(function() {
     $('html, body').animate({
         scrollTop: $("#how-it-works-frame").offset().top-125
     }, 2000);
 });
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
setInterval(function(){render.latestFeedback();},1000);

if (member_login) {
	$('#latest-feedback-add-form').show();
	render.latestFeedbackAddForm();
	render.homePage(3);
}else render.homePage(4);
render.latestFeedback();
</script>
<?php include "template/footer.php" ;?></body>
</html>
