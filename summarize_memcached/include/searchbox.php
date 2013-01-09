<?php 
if (isset($_SESSION['uid'])){
$count=0;
$follows=$database->query("Select * from notifications_follow where uid='".$_SESSION['uid']."'");
$q="";
while ($info=mysql_fetch_array($follows)){
		$q=$q."(`idproduct`='".$info['product']."' and `date`>'".$info['date']."') OR ";
}
$follows=$database->query("select * from notifications where $q 1=2 ORDER BY `date` DESC;");
if (mysql_num_rows($follows)<1){
	$count=0;
} else {
	$count=mysql_num_rows($follows);
}			
}
?>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
			<a class="brand" href="index.php">Summarize</a>
            <div class="nav-collapse">
                <ul class="nav">
					<?php if (isset($_SESSION['uid'])) {?>
					<li><a href="add-item.php">Add Item</a></li>
					<?php } ?>
                </ul>
            </div>
			<div id="user-menu" >
			<ul class="nav">
			<li>
				<?php 	
						$ok=false;
						if (array_key_exists('uid',$_SESSION)){
							
							$data=$database->query("Select * from users where `uid`='".$_SESSION['uid']."';");
							$info=mysql_fetch_array($data);
							$logintype=$info['logintype'];
							if ($page=="result.php"){
								echo "<span id='ask-expert' onclick=\"window.location.href='expert.php?id=".$id."'\">Ask an expert?</span>";}
							else{
								echo "<span id='ask-expert' onclick=\"window.location.href='tag-expert.php'\">Ask an expert?</span>";
							}
							if($logintype=="facebook"){
								echo "<img style='float:left;margin-top:4px;border: 2px solid #F8F8F8;' src='https://graph.facebook.com/".$_SESSION['username']."/picture' width='30' height='30'>";
								$ok=true;
							}
							if($logintype=="twitter"){
								echo "<img style='float:left;margin-top:3px;border: 2px solid #F8F8F8;' src='".$info['profileimageurl']."'  width='30' height='30'>";
								$ok=true;
							}
							if($logintype=="normal"){
								echo "<img style='float:left;margin-top:3px;border: 2px solid #F8F8F8;' id='logimg' src='".$info['profileimageurl']."'  width='30' height='30'>";
								$ok=true;
							}
						}
						
				?>
				</li>
				
				
				<? if (array_key_exists('uid',$_SESSION)){if ($info['username']!=""){ ?>
				
				<li>
				<div id="user-welcome">
				<span id="profile-link" onclick="window.location.href='profile.php'"><?=$info['username']?></span>
				</div>
				</li>
				<li>
						<div id="noti-count" ><?php echo $count; ?></div>				
					</li>
				<? }else{ ?>
				

				<? }}?>
				
				
				
				<?php if($ok){ ?>
				<li class="active" >
					
					<ul id="user-dropdown">
						<li onclick="window.location.href='profile.php?a=profile'">Account Settings</li>
						<li onclick="window.location.href='profile.php?a=activity'">Recent Activity</li>
						<li onclick="window.location.href='profile.php?a=notifications'">Notifications</li>
						<li onclick="window.location.href='profile.php?a=points'">Points</li>
						<li onclick="window.location.href='profile.php?a=messages'">Messages</li>
						<li onclick="document.logout.submit();">Log Out</li>
					</ul>
			    <form name='logout' method="POST" action="process.php" style="margin:9px; 0 0 0;">
				<input type="hidden" name='logout'>
				<a id='nav-a'  href="#"><img onclick='menuF();' src='images/down-arrow.png' class='logout-img'></a>
				</form>
				</li>
				
				<?php } else { ?>
				<li class="active" onclick="window.location.href='login.php'">
				<a id='nav-a'  href="#">Log In</a>
				</li>
				<?php }?>
			</ul>
			</div>
        </div>
		
    </div>
</div>
<div class="container">
  <div >
	<div id="search_box" align="center" x>
	
	<button style="float:right;margin-top:8px;height:30px;padding-top: 5px;margin-top: 3px;height: 45px;height: 45px;margin-right: 200px;" onclick="window.location.href='advance.php';return false;"  class="btn btn-warning start">
	<i class="icon-search icon-white"></i>
	<span>Adv</span>
	</button>
	<form name="search" method="POST" action="process.php" style="width: 645px;margin:0px auto 0px auto;">
	<button style="float:right;width:100px; height:34px;margin-top:8px; padding-top: 5px;margin-right:15px;" onclick="verify();" id='searchbtn' class="btn btn-info start">
	<i class="icon-search icon-white"></i>
	<span>Search</span>
	</button>
	<input type="text"  name="q" id="query" autocomplete="off" placeholder='Enter search items' style="margin-right:5px;float:right;width: 497px; height:23px;margin-top:9px;">
	<input type="hidden" name='search'>
	
	
	</form>
	
	</div>
	
  </div>
 </div>
<div style="background-color:#289BDB;width:100%;height:5px;"></div>
  </div> 
 </form>   
  </div>	
  </div>