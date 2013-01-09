<?php 
session_start();

require_once "include/database.php";
require_once "include/memcached.php";
require_once "include/result.functions.php";

if ($id==''){$id=$_GET['id'];}

// Variables
$productInfo    = getProductData($id);
$categories     = getProductCategories($id);
$addedByInfo    = $database->getUserInfo($productInfo['userID']);
$page           = "result.php";
$logintype      = getLoginType();
$url			= curPageURL();
$tags 			= $productInfo['tags'];
$name 			= $productInfo['name'];
$comment	    = stripslashes($productInfo['comment']);
$shortComment   = parseComment($comment);
$shareImage		= getShareImage($logintype);
$shareText		= getShareText($logintype);
$imgPath        = getProductImagePath($id);
$imgCover		= renderProductImage($imgPath);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<title><?=$name;?></title>
	<?php include "include/header.php";	?>
	<body>
	<script>
		var pid = "<?=$id?>";
		var pname = "<?=$name?>";
		var logged = <?php if (isset($_SESSION['uid'])){echo 'true';} else {echo 'false';};?>;
	</script>
    <?php include "include/searchbox.php"; ?>
	<div id="container">	
	<div id="innercontainer" >
		<div class="summary" style="width:990px;padding-bottom:0px;">
			<h2 style="float:left;"><?=$name;?></h2>
			<button style="float:right;margin:3px 5px 0 5px;" onclick="showCompare();" class="btn btn-primary start">
				<i class="icon-star icon-white"></i>
				<span>Add To Compare</span>
			</button>
			<div style="float:right;margin:3px 0 0 0; font-size:12px;" id="product<?=$id;?>"><?php include "include/follow_button.php";?></div>
			
			<div id="block" style="margin-top:40px;"></div>
			<div class="SumLeft">
				<?=$imgCover;?>
				<div style="float:right;width:815px;">
					<div style="margin-left:10px;margin-top:10px;">
					<textarea style="margin-left:10px;height:100%;" id='tags'><?=$tags;?></textarea>
					<p id="comment" style="margin-left:5px;">
					<?=$shortComment;?>
					</p>
					</div>
				</div>
			</div>	
			<div class="prod-poster" style='height: 45px;'>
					<table style="float:left;">
					<tr>
					<td>
					<?=$shareImage;?>
					</td>
					<td style="cursor:pointer;color: #3D8EFF;font-weight: bold;font-size: 15px;">
					<?=$shareText;?>
					</td>
					<td></td>
					<td>
					<img src='images/chat.png' onclick="fadeDiv('#faq',1);" style='cursor:pointer;height:50px;'  />
					</td>
					<td onclick="fadeDiv('#faq',1);" style="cursor:pointer;color: #3D8EFF;font-weight: bold;font-size: 15px;">
					FAQ and forum
					</td>
					</tr>
					</table>
					<table style="float:right;margin-top:5px;">
					<tr>
					<td>
					Added by  <a href="user.php?uid=<?=$addedByInfo['userID'];?>"><?=$addedByInfo['username'];?></a><img src="<?=$addedByInfo['profileimageurl']; ?>" style="2px solid #CECECE;margin-left:5px;margin-bottom:7px;height:30px;">
					</td>
					</tr>
					</table>
			</div>
		</div>
		<div class="summary" id="faq" style="width:990px;display:none;">
		<button style="float:right;margin:10px 0 0 5px;" onclick="fadeDiv('#faq',0);" class="btn btn-primary start">
			<i class="icon-remove-circle icon-white"></i>
			<span>Hide FAQ</span>
		</button>			  
			<h2 >Questions for <a href='<?=$name?>'><?=$name?></a></h2>
			<div id="block"></div>
			<input type="text" style="width: 860px;margin-bottom:10px;" id="find" placeholder="Find question...">
			<button  style="margin-top:-10px;" onclick="highlight();" class="btn btn-primary start"><i class="icon-search icon-white"></i><span>Find question</span></button>
			<div id="q-container" style="margin:10px 0 10px 0;">
			</div>
			<table><tr><td>
			<input type="text" style="width:855px;margin-bottom:10px;" id="question" placeholder="Ask here..." >
			</td><td>
			<button  onclick="postQue()" class="btn btn-primary start" style='margin-top:-10px;'><i class="icon-upload icon-white"></i><span>Post question</span></button>
			</td>
			</tr>
			</table>
		</div>
		<!-- Chart -->
		
		<div  class='summary' style="width:990px;display:none;" id="compare-sum">
			<span id="title" style="float:left;">Compare items:</span>
			<button style="float:right;margin:15px 0 0 5px;" onclick="window.location.href='compare.php';" class="btn btn-primary start">
				<i class="icon-list-alt icon-white"></i>
				<span>Compare Now</span>
			</button>
			<div id="block" style="margin-top:50px;"></div>
			<div id="compare-list" style="margin-bottom:10px;"></div>   
			<div id="add-search-box">
				<div id="block"></div>
				<table>
				<tr>
				<td>
				<input type="text" class="textbx" style="width:750px;height:18px;" name="qc" id="qc" placeholder='Enter items to compare...' /> 
				<td>
				</td>
				<button style="float:right;margin:0 0 0 5px;" onclick="hideCompare();" class="btn btn-primary start">
					<i class="icon-ok icon-white"></i>
					<span>Done</span>
				</button>
				<td>
				</td>
				<button style="float:right;margin:0 0 0 5px;" onclick="addNewToCompareByName();" class="btn btn-primary start">
					<i class="icon-search icon-white"></i>
					<span>Add To Compare</span>
				</button> 
				</td>
				</tr>
				</table>
			</div>
		</div>

		<div class="summary" id="graph-summary" style="width:990px;height:450px;display:none;">
		<button style="float:right;margin:15px 0 0 5px;" onclick="hideGraph();" class="btn btn-primary start">
			<i class="icon-remove-circle icon-white"></i>
			<span>Hide Graph</span>
		</button>			  
		<?php include"include/chart.php"?>
		</div>
		  
		<div class="summary" style="width:990px;"> 
		<h2  style="float:left;">Categories:</h2>
		<span id="comment-good" style="float:left;margin-top:4px;margin-left:10px;">Positive</span>
		<span id="comment-bad" style="float:left;margin-top:4px;margin-left:10px;">Negative</span>		  
		
		<a class="btn" style="float:right;margin:4px 0 0 5px;" onclick="showAllCat();return false;" href="#">Show All</a>
		<a class="btn" style="float:right;margin:4px 0 0 5px;" onclick="showGraph();return false;" href="#">View Graph</a>
		<a class="btn" style="float:right;margin:4px 0 0 5px;" onclick="goToFeed();return false;" href="#">Add Feedback</a>
		<div id="block" style="margin-top:40px;"></div>
		<!-- Categories start here  -->
		<div id='category-container'>
		<?php

		$showAllCat = "[";
		foreach ($categories as $fc){
		$showAllCat .= "'".$fc['id']."',";
		?>
			<div id="category-box">
				<div onclick="fill(['<?=$fc['id']?>'],'<?=$fc[0];?>','<?=$id;?>');" class="cat-h2">
					<span style="float:left;padding-right:10px;">
					<font id="good-<?=$fc['id']?>" color="#4EC5F7" style="border-right:2px solid #C2C2C2;padding-right:5px;"><?php if($fc['good']==''){ echo "0";}else{echo $fc['good'];};?></font>
					<font id="bad-<?=$fc['id']?>" color="#DB3535"><?php if($fc['bad']==''){ echo "0";}else{echo $fc['bad'];};?></font>
					</span> 
					<span class="cat-name-box"  id="cat-<?=$fc['id']?>" style="float:left;"><?=$fc[0];?></span>
				</div>
				<span style="float:right;padding-right:10px;width:22px;cursor:pointer;" onclick="editCat(<?=$fc['id']?>,'<?=$fc[0];?>',<?=$id;?>);"><img style="margin-top: -2px;" src="images/edit.png"></span>
				<span style="float:right;padding-right:10px;width:22px;cursor:pointer;" onclick="addFeedForm(<?=$fc['id']?>);"><img style="margin-top: -2px;" src="images/plus.png"></span>
				<div id="<?=$fc['id']?>" style="width:100%;padding-top:25px;padding-bottom:3px;">
				</div>
			</div>
		<?php 
		} 
		$showAllCat = substr_replace($showAllCat ,"",-1);
		$showAllCat .= "]"; 
		?>
		</div> 
		  
		  <!-- Categories end here  -->
		 
		  <div id="block" class='postBlock' style="margin-bottom:5px;"></div>
		  <table>
		  <tr>
		  <td>
		  <input type="text" style="width:300px;margin-bottom:0px;height: 20px;" id="catFeed" placeholder='Category...'>
		  </td>
		  <td>		  
			<input type="text" style="width:440px;margin-bottom:0px;height: 20px;" id="feed" placeholder='Feedback...'>
			</td>
			<td>
			<td>
			<input type="checkbox" name="typeFeed" class='switch' id='typefeed' style="margin-left:5px;width:85px;margin-bottom:0px;float:right;">
			</td>
			<td>
			<button style="width:108px;height: 30px;margin-left:5px;margin-bottom:2px;" id='btnPost' onclick="addFeedback('')" class="btn btn-primary start"><i class="icon-upload icon-white"></i><span>Post</span></button>
			</td>
			</tr>
			</table>
		</div>
	   

	   
		   <div id="innercontainer2">
		     
	   </div>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
	<script src="js/jquery.tagify.js"></script>
	<script src="js/compare.list.functions.js"></script>
	<script src="js/result.functions.js"></script>
  <script>

  function showAllCat(){
	fill(<?=$showAllCat;?>);
  }
  
	var TagArea = $('#tags').tagify();

	TagArea.tagify('inputField').autocomplete({
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
											?>],
											position: { of: TagArea.tagify('containerDiv') },
											select: function(event, ui) {setTimeout(function() { TagArea.tagify('add'); 
																	str = TagArea.tagify("serialize").replace(" ","").split(",");
																	str = str[str.length-1];
																	saveTag(str);
																},10);},
											close: function(event, ui) {},
	});
    
</script>	

<div id="boxes">
<div id="dialog" class="window">
<a href="#"class="close"/>
<img style="margin:10px 10px 10px 10px;border:3px solid #707070 ;" src="upload/<?=$imgPath?>">
</a>
</div>
<div id="dialog-more" class="window" style="border:4px solid gray;width:400px;padding:10px 10px 10px 10px;border-radius:5px 5px 5px 5px;">
<a href="#"class="close" style="text-decoration:none;color:white;"/>
<?=$comment; ?>
</a>
</div>  
<!-- Mask to cover the whole screen -->
<div id="mask"></div>
</div>
</body>
</html>
