<?php 
session_start();
include "include/database.php";
if (!isset($_SESSION['uid'])){Redirect('login.php');}
$name = $_GET['name']; 
$ud=$database->query("Select * from users where `uid`='".$_SESSION['uid']."' ");
$ud=mysql_fetch_array($ud);
$logintype=$_SESSION['login'];
if ($logintype=="facebook"){$shareText="Share on facebook";$img = ("<img src='images/fb-icon.png'  id='share-img'  />");}
if ($logintype=="twitter"){$shareText="Share on twitter";$img = ("<img src='images/twittershare.png' style='cursor:pointer;height:50px;'  />");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include "include/header.php";?>
	  <script type="text/javascript" src="js/jquery.form.js"></script>
	<body>
    <div id="main">
       <?php include "include/searchbox.php"; ?>
	  
      <div id="container" >
        <div id="innercontainer">
		  
			<div class="summary" id="big-sum" style='padding-bottom:0px;'>
		              
                <!-- First Set  Starts Here  -->
               
				<table><tr><td><input id="url" name="url" type="text"  style="width:850px;margin-bottom:5px;" placeholder='URL of product from Amazon,Groupon...'/></td><td><button style="margin-left:5px;float:right;margin-right:5px;margin-top:-5px;" onclick="crawlDesc();" class="btn btn-primary start">
					<i class="icon-upload icon-white"></i>
					<span>Get article</span>
					</button></td></tr></table>
                <input maxlength="40" id="name" name="name" type="text"  value="<?=$name?>"  style="width:980px;margin-bottom:5px;" placeholder='Name...'/> 
				
				<div id='test'></div>
				<div id='block'></div>
				<table>
				<tr>
				<td valign='top'>
				
				<label id="img-label">
				<form id="imageform" method="post" enctype="multipart/form-data" action='include/ajaximage.php' style='margin:0px;'>
				
				<input type="file" name="photoimg" id="photoimg" />
				</form>
				 
				<div id='preview'>
				</div>
				</label>
				
				</td>
				<td>
                <div id='add-left'>
				
				
				<textarea id="textarea" >sample tag</textarea> 
				
				 <textarea id="comment" name="comment" class='add-desc' placeholder='Description...' type="text" /></textarea>
                 
                   <div type="hidden" id="tags"></div><input type="hidden" name="addproduct"/>
				</div>
				</td>
				</tr>
				</table>
				<div class="prod-poster" style='height:55px;'>
					<table style="float:left;">
					<tr>
					<td>
					<?=$img;?>	
					</td>
					<td  id='table-text'>
					<?=$shareText;?>
					</td>
					<td></td>
					<td>
					<img src='images/chat.png' id='share-img'  />
					</td>
					<td id='table-text'>
					FAQ and forum
					</td>
					</tr>
					</table>
					<table style="float:right;margin-top:20px;">
					<tr>
					<td>
					Added by  <a href="user.php?uid=<?=$_SESSION['uid'];?>"><?=$_SESSION['username'];?></a><img src="<?=$_SESSION['photo']; ?>" id='add-user-img' >
					</td>
					</tr>
					</table>
			</div>	
			</div>	
			<div class="summary" id="big-sum">
			<span id="title">Cateogories:</span>
			<div id='block'></div>
					<table>
					<tr>
					<td>
					<input type="text" style="width: 250px;margin-bottom:0px;height: 16px;" id="catFeed" name="catFeed" placeholder='Feedback Category...'>
					 </td>
					 <td>
					 <input type="text" style="width: 450px;margin-bottom:0px;margin-left:5px;margin-right: 5px;height: 16px;" id="feed" name="feed" placeholder='Feedback...'>
					</td>
					<td>
					<input type="checkbox" name="typeFeed"  id='typefeed' class="switch" style="margin-left:5px;width:85px;margin-bottom:0px;float:right;">
					</td>
					<td>
					<button style="margin-left:5px;float:right;margin-right:5px;margin-top:-2px;" onclick="subForm();return false;" class="btn btn-primary start">
					<i class="icon-upload icon-white"></i>
					<span>Post</span>
					</button>
					</td>
					</tr>
					</table>
					
					
			</div>
		
		<?php
		if ($name!=''){
		?>

		<div class="summary" id="big-sum">
		<span id='title'>Similar Tags:</span>
        <div id='block'></div> 
		<?php
		$data=$database->query("SELECT * FROM `product` WHERE tags LIKE '%".$name."%'");
		$unique_tags = array();
		while ($info=mysql_fetch_array($data))
		{
			$tags=explode(",",$info['tags']);
			$unique_t = array();
			foreach ($tags as &$tag) 
			{
				array_push($unique_t,str_replace(" ", "", $tag));
			}
			$unique_tags = array_merge($unique_tags,$unique_t);
		}
		$unique_tags=array_unique($unique_tags);
		$str=null;
		foreach ($unique_tags as &$tag) 
		{
			$tag = str_replace(" ", "", $tag);
			if (strpos($tag, $name)===false){}else{echo "<span id='tag' onclick=\"window.location.href='similar.php?tag=".$tag."';\" style='cursor:pointer;'>".$tag."</span>";}
		}
		?>
		
		</div>
		<div id="innercontainer2">
		</div>
		
		<?php }?>
	</div>
  </div>
</div>
<script src='js/jquery.autosize-min.js'></script>
  <script>
 
  $(document).ready(function(){
    $('#comment').autosize();  
});
  function crawlDesc(){
	$.post('include/extract_html.php',{url: $('#url').val(),title:true},function(data){$('#name').val($.trim(data));});
	$.post('include/extract_html.php',{url: $('#url').val(),description:true},function(data){$('#comment').val($.trim(data));$('#comment').autosize();});
	}
   $("#file").change(function (){
  var ext = $('#file').val().split('.').pop().toLowerCase();
	if($.inArray(ext, ['png','jpg']) == -1) {
		$('#upimg').html($('#upimg').html());
		alert("Please select jpg or png images!");
	}
	else
	{}});
	function saveTags(){
	}
    var myTextArea = $('#textarea').tagify();

    myTextArea.tagify('inputField').autocomplete({
	source: [ <?php 
				$data=$database->query("SELECT * FROM `product`");
				$unique_tags = array();
				while ($info=mysql_fetch_array($data))
				{
					$tags=explode(",",$info['tags']);
					$unique_t = array();
					foreach ($tags as &$tag) 
					{
						array_push($unique_t,str_replace(" ", "", $tag));
					}
					$unique_tags = array_merge($unique_tags,$unique_t);
				}
				$unique_tags=array_unique($unique_tags);
				$str=null;
				foreach ($unique_tags as &$tag) 
				{
					$tag = str_replace(" ", "", $tag);
					$str=$str.'"'.$tag.'",';
				}
				$str=substr_replace($str ,"",-1);
				echo $str;
				?>]
		,
        position: { of: myTextArea.tagify('containerDiv') },
		select: function(event, ui) {setTimeout(function() {myTextArea.tagify('add');},10);},
        close: function(event, ui) { },
    });
	
    
    function subForm(){

	var ok=true;
	if ($('#name').val()==''){ok=false;}
	if ($('#catFeed').val()==''){ok=false;}
	if ($('#feed').val()==''){ok=false;}
	if ($('#comment').val()==''){ok=false;}
	if (ok){
		var tagStr = $('#textarea').tagify('serialize');
		$.post('process.php',{addproduct: true,name: $('#name').val(),tags: tagStr,comment: $('#comment').val(),catFeed: $('#catFeed').val(),feed: $('#feed').val(),typeFeed: $('#typeFeed').val(), img: $('.preview').attr('src')},function(data){window.location.href=data;});
	}
	}
  </script>
  	   <script type="text/javascript">
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


