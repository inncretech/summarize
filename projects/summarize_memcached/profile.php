<?php 
session_start();
$page="profile.php";
include "include/database.php"; 
if (empty($_SESSION['uid'])){
	Redirect("login.php");
} 
$uid = $_SESSION['uid'];
$action=$_GET['a'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php 
	include "include/header.php";
	?>
	<script type="text/javascript" src="js/jquery.form.js"></script>
	<body>
    <div id="main">   
       <?php include "include/searchbox.php"; ?>
	   
      <div id="container" >
	  <?php
		$data=$database->query("Select * from users where `uid`='".$uid."' ");
		$data=mysql_fetch_array($data);
		$logintype=$data['logintype'];
		$username=$data['username'];
		$pd = $database->query("Select * from product where `userID`='".$uid."' ORDER BY RAND() LIMIT 0,4;");
		$pd_num_rows = mysql_num_rows($pd);
		
		$fpd = $database->query("Select * from notifications_follow where `uid`='".$uid."' ORDER BY RAND() LIMIT 0,4;");
		$fpd_num_rows = mysql_num_rows($fpd);
	  ?>
	  
        <div id="innercontainer">
		<div class="userbox" > 
	<?php if($logintype=="normal"){
	?>
	<label id="img-label" style='background-size: auto;'>
				<form id="imageform" method="post" enctype="multipart/form-data" action='include/upUserImg.php' style='margin:0px;'>
				
				<input type="file" name="photoimg" id="photoimg" />
				</form>
				 
				<div id='preview'>
				
				<?php if ($data['profileimageurl']!="no-pic.jpg") {?>
				<script>$('#img-label').css('background-image',"url('<?=$data['profileimageurl']?>')");</script>
				<?php }?>
				</div>
				</label>
	<?
	}else{?>
	<img style="border: 2px solid #F8F8F8;" src='<?=$data['profileimageurl'];?>' style="padding:10px;"/>
	<?php }?>
	<div class="prod-poster" style='height:100%;'>
			<div class="prod-poster-text" >
				<a href="user.php?uid=<?=$data['uid'];?>"><?=$data['fname']." ".$data['lname'];?></a>
				<hr>
				<?php 
				if ($pd_num_rows==null){echo "No products added.";}else{
				echo "<b onclick=\"load('added');\" style='cursor:pointer;'> Products Added: </b><br>";
				
				while($pi = mysql_fetch_array($pd)){ 
				if (file_exists("upload/".$pi['idproduct'].".jpg")){$path=$pi['idproduct'].".jpg";}else{$path="no-pic.jpg";
				if (file_exists("upload/".$pi['idproduct'].".png")){$path=$pi['idproduct'].".png";}else{$path="no-pic.jpg";}}
				?>
				<a href="result.php?id=<?=$pi['idproduct']?>"><img src='upload/<?=$path;?>' class='follow-img'></a>
				<?php }
				} 
				?>
				<hr>
				<?php 
				
				if ($fpd_num_rows==null){echo "No products followed.";}else{
				echo "<b onclick=\"load('follow');\" style='cursor:pointer;'> Products Followed: </b><br>";
				
				while($fpi = mysql_fetch_array($fpd)){
				$fd = $database->query("Select * from product where `idproduct`='".$fpi['product']."'");
				$fi = mysql_fetch_array($fd);
				if (file_exists("upload/".$fi['idproduct'].".jpg")){$path=$fi['idproduct'].".jpg";}else{$path="no-pic.jpg";
				if (file_exists("upload/".$fi['idproduct'].".png")){$path=$fi['idproduct'].".png";}else{$path="no-pic.jpg";}} 
				?>
				<a href="result.php?id=<?=$fi['idproduct']?>"><img src='upload/<?=$path;?>' class='follow-img'></a>
				<?php }
				} 
				?>
				<hr>
				<ul style="float:none;">
				<li>
				<a href="#" onclick="load('profile');">Account Settings</a></li><li>
				<a href="#" onclick="load('activity');">Recent Activity</a></li><li>
				<a href="#" onclick="load('notifications');">Notifications</a></li><li>
				<a href="#" onclick="load('points');">Points</a></li><li>
				<a href="#" onclick="load('messages');">Messages</a></li><li>	
				<a href="#" onclick="load('expert');">Expert Level</a></li>	
				</ul>
				<hr>
				<?
				include "include/invite.php";
				?>
				
				
				
			</div>
			
	</div>
  </div>
         <div class='summary' style="margin-left:0px;">
				
                <!-- First Set  Starts Here  -->
                
                <?php 
				
				
			
				include("include/activity.php");
			
				include 'include/notifications.php';
			
				include 'include/points.php';
				
				
			
				if($logintype=="facebook") include("include/fb-profile.php");
				if($logintype=="twitter") include("include/tw-profile.php"); 
				if($logintype=="normal") include("include/normal-profile.php"); 
				include "include/exp-lvl.php";
				
				include "msg/msg.php" ;
				?>	
				</div>
				<div>
				<?php include 'include/follow-items.php';?>
				<?php include 'include/added-items.php';?>
				</div>
				<div class='summary' id='user-activity' style='margin-left:0px;display:none;margin-bottom:50px;'></div>
          </div>
        </div>
	 </div>
<div id="boxes">
<div id="dialog" class="window" style="border-radius: 10px;width:400px;height:70px;color:#808080;padding:10px;background: url('images/light_toast.png');border: 10px solid  #68C2DC;font-size: 1.2em;font-weight: bold;">
<p>Invite your friends to Summarize with you!</p>
<input type="text" id="mail-to" placeholder="Enter email">
<button  onclick='sendMail();' style="margin-top: 0px;" class='btn btn-info start'><i class='icon-upload icon-white'></i><span>Summarize with friend</span></button>
</div>
<!-- Mask to cover the whole screen -->
<div id="mask"></div>
</div>
<script>
var action = "<?=$_GET['a'];?>";
load(action);
function hideAll(){
	$('#activity-div').css('display','none');
	$('#notification-div').css('display','none');
	$('#user-table').css('display','none');
	$('.user-table').css('display','none');
	$('#expert-div').css('display','none');
    $('#points-div').css('display','none');
	$('#msg-container').css('display','none');
	$('#follow-div').css('display','none');
	$('#added-div').css('display','none');
}
function load(a){
	switch(a)
	{
	case "activity":
		hideAll();
		$('#activity-div').fadeIn();
		break;
	case "notifications":
		hideAll();
	  $('#notification-div').fadeIn();
	  break;
	case "profile":
		hideAll();
		$('.user-table').fadeIn();
		$('#user-table').fadeIn();
		break;
	case "expert":
		hideAll();
		$('#expert-div').fadeIn();
		break;
	
	case "messages":
		hideAll();
		$('#msg-container').fadeIn();
	break;
	case "points":
		hideAll();
		$('#points-div').fadeIn();
	break;
	case "follow":
		hideAll();
		$('#follow-div').fadeIn();
	break;
	case "added":
		hideAll();
		$('#added-div').fadeIn();
	break;
	default:
		hideAll();
		$('#user-table').fadeIn();
		$('.user-table').fadeIn();
	}
}
function fillActivity(user,tag){
  var str = '';
  $('#user-activity').html('<button style="float:right;margin-top:5px;" onclick="closeActivity();" class="btn btn-primary start"><i class="icon-star icon-white"></i><span>Close</span></button>');
		
	  $.post("include/getActivity.php", {u: user,t: tag},function(data){
		data = $.parseJSON(data);
		if (data.length==0){str +='<span id="title" style="font-size:1.8em">Points earned rating feedback!</span>';}else
		{
			  $.each(data, function (i,v){
				str +='<span id="title">'+v.product.name+'</span><hr style="margin:0px;margin-top:5px;"><div>';
				var feed = v.feedback;
				var aux=0;
				var cat='';
				while (feed[aux]!=null){
				    if ((feed[aux].category) != cat){cat = feed[aux].category; str +="</div><div id='category-box' style='margin-top:5px;' ><span id='title' style='height:50px;font-size: 1.6em;margin-left:5px;' >"+cat+"</span>";}
				    str +='<div id="comment-'+feed[aux].type+'" style="margin: 0 5px 5px 5px;">'+feed[aux].comment+'</div>';
					aux=aux+1;
				}
				str +="</div>";
			  });
		}
	    $('#user-activity').append(str);
		$('#user-activity').fadeIn("slow");
	  });
}
function closeActivity(){
	$('#user-activity').fadeOut();
	
}
$(document).ready(function() { 
		
            $('#photoimg').live('change', function()			{ 
			           $("#preview").html('');
			    $("#preview").html('<img src="images/loader.gif" style="width:160px;" alt="Uploading...."/>');
			$("#imageform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});
        }); 
</script>
</body>
</html>
