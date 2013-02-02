<?php 
session_start(); 
include "include/database.php";
$pid = $_GET['pid'];
$d = $database->query("SELECT * FROM `product` WHERE `idproduct`= '$pid'");
$i = mysql_fetch_array($d);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include "include/header.php"; ?>
	<body>
    <div id="main">  
      <?php include "include/searchbox.php"; ?>   
      <div id="container" >
        <div id="innercontainer">
          <div class="summary" style="width:990px;">
			<span id='title'>Questions for <a href='result.php?id=<?=$pid;?>'><?php echo $i['name'];?></a></span>
			<div id="block"></div>
			<input type="text" style="width: 860px;margin-bottom:10px;" id="find" placeholder="Find question...">
			<button  style="margin-top:-10px;" onclick="highlight();" class="btn btn-primary start"><i class="icon-search icon-white"></i><span>Find question</span></button>
			<div id="q-container" style="margin:10px 0 10px 0;">
			</div>
			<input type="text" style="width:980px;margin-bottom:10px;" id="question" placeholder="Ask here..." ><br>
			<button style="width:990px;"  onclick="postQue()" class="btn btn-primary start"><i class="icon-upload icon-white"></i><span>Post question</span></button>
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
		getQue();
		function postQue(){if (ok){$.post("include/postQue.php",{que: $('#question').val(), pid: '<?=$pid?>'},function(data){getQue();});}else{window.location.href='login.php';}}
		function getQue(){$.post("include/getQue.php",{pid: '<?=$pid?>'},function(data){
		 data = $.parseJSON(data);
		 $('#q-container').html('');
		 $.each(data, function (i,v)
		 {
			$('#q-container').append("<div style='width:700px;text-align:left;padding:0 0 5px 0;'><span style='font-size:15px;cursor:pointer;color: #08C;' onclick='window.location.href=\"user.php?uid="+v.uid+"\"'>"+v.user+" : </span><span class='highlightable' style='font-size:15px;cursor:pointer;color: #999;' onclick='window.location.href=\"answers.php?qid="+v.qid+"\"'> "+v.que+"</span></div>");
		 });
		});}
	</script>
</body>
</html>
