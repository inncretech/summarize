<?php 
session_start(); 
include "include/database.php";
$qid = $_GET['qid'];
$d = $database->query("SELECT * FROM `questions` WHERE `id`= '$qid'");
$i = mysql_fetch_array($d);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include "include/header.php"; ?>
	<script src="js/iphone-style-checkboxes.js" type="text/javascript"></script>
	<body>
    <div id="main">  
      <?php include "include/searchbox.php"; ?> 
	  
      <div id="container" >
        <div id="innercontainer">
         <div class="summary" style="width:990px;">
			<span id='title'><?php echo $i['question'];?></span>
			<div id="block"></div>
			<input type="text" style="width:868px;margin-bottom:10px;" id="find" placeholder="Find answer...">
			<button  style="margin-top:-10px;" onclick="highlight();" class="btn btn-primary start"><i class="icon-search icon-white"></i><span>Find answer</span></button>
			<div id="a-container" style="margin:10px 0 10px 0;">
			</div>
			<br>
			<input type="text" style="width:300px;margin-bottom:2px;height:20px;" id="category" placeholder="Feedback Category..." >
			<input type="text" style="width:540px;margin-bottom:2px;height:20px;margin-left:1px;margin-right: 1px;" id="subject" placeholder="Feedback...">
			<input type="checkbox" name="typeFeed"  id='typefeed' class="switch" style="margin-bottom:10px;float:right;">
			<br>
			<textarea style="width:980px;height:100px;margin-bottom:5px;" id="answer" placeholder="Leave your answer here..."></textarea><br>
			<button style="width:990px;"  onclick="postAns()" class="btn btn-primary start"><i class="icon-upload icon-white"></i><span>Post answer</span></button>
            </div>
            
          </div>
        </div>
        
	  </div>
	<script src='js/SearchHighlight.js'></script>
	<script>
	function highlight(){
	$(".hilite").each(function(){$(this).parent().html($(this).parent().text());});
		var str = $('#find').val();
		var options = {
			exact:"partial",
			style_name_suffix:false,
			highlight:".highlightable",
			keys:str
		}
		jQuery(document).SearchHighlight(options);
	}
	</script>
	<script>
		<?php if (isset($_SESSION['uid'])){echo "var ok=true;";}else{echo "var ok=false;";}?>
		getAns();
		function postAns(){if (ok){$.post("include/postAns.php",{pid: <?=$i['idproduct'];?>,type: $('#typeFeed').val(),cat: $('#category').val(),sub: $('#subject').val(),ans: $('#answer').val(), qid: '<?=$qid?>'},function(data){getAns();});}else{window.location.href='login.php';}}
		function getAns(){$.post("include/getAns.php",{qid: '<?=$qid?>'},function(data){
		 data = $.parseJSON(data);
		 $('#a-container').html('');
		 
		 $.each(data, function (i,v)
		 {
			$('#a-container').append("<div style='text-align:left;padding:0 0 5px 0;margin-bottom:20px;'><span style='font-size:15px;cursor:pointer;color: #08C;' onclick='window.location.href=\"user.php?uid="+v.uid+"\"'>"+v.user+" : </span><span class='highlightable' style='font-size:15px;cursor:pointer;color: #999;' >"+v.ans+"</span><div style='float:right;margin-top:15px;color: #999;'>Posted on "+v.date+"</div></div>");
		 });
		});}
	</script>
</body>
</html>
