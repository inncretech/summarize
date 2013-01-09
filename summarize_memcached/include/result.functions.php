<?php
function getProductData($id){
    global $database;
	global $memcached;
	
	$ok=false;
	if ($memcached->check){
		$info = $memcached->connection->get('p-'.$id);
		if($info==''){
			$ok=true;
		}
	}else{
		$ok=true;
	}
	if ($ok){
		$data=$database->query("SELECT * FROM product WHERE idproduct='".$id."'");
		$info=mysql_fetch_array($data);		
	}
	return $info;
}

function getProductCategories($id){
	global $database;
	global $memcached;
	
	$ok = false;
	
    if ($memcached->check){
		$info  = $memcached->connection->get('c-'.$id);
		if($info==''){
			$ok=true;
		}
	}
	else{
		$ok=true;
	}
		
	if ($ok){
		$data=$database->query("SELECT DISTINCT `category` , id , (SELECT SUM(thumb) FROM feedback WHERE `idproduct` = '".$id."' AND category=f1.category AND type='good') as good ,(SELECT SUM(thumb) FROM feedback WHERE `idproduct` = '".$id."' AND category=f1.category AND type='bad') as bad FROM `feedback` as f1 WHERE `idproduct` = '".$id."' GROUP BY `category`"); 
		$aux=0;
		while ($row=mysql_fetch_array($data)){
			$info[$aux] = $row;
			$aux=$aux+1;
		}
	}
	return $info;
}
function parseComment($comment){
	if (strlen($comment)>350) {
		$val=substr($comment, 0, 350)."...<a href='#dialog-more'  name='modal' style='text-decoration: none;color: #4792FF;'>more</a>";
	}else
	{
		$val=$comment;
	}
	return $val;
}
function getShareImage($type){
	$shareImage = null;
	if ($type=="twitter") {$shareImage="<img src='images/twittershare.png' onClick='tweetIt()' style='cursor:pointer;height:50px;'  />";}
	if ($type=="facebook"){$shareImage="<img src='images/fb-icon.png' onClick=\"fbPost('".$url."','".$name."')\" style='cursor:pointer;height:50px;'  />";}
	return $shareImage;
}
function getShareText($type){
	$shareText = null;
	if ($type=="facebook"){$shareText="Share on facebook";}
	if ($type=="twitter") {$shareText="Share on twitter";}
	return $shareText;
}
function getProductImagePath($id){
	$path = null;
	if (file_exists("upload/".$id.".jpg")){$path=$id.".jpg";}else{$path="no-pic.jpg";
	if (file_exists("upload/".$id.".png")){$path=$id.".png";}else{$path="no-pic.jpg";}}
	return $path; 
}
function renderProductImage($path){
	$upload = false;
	if ($path=="no-pic.jpg"){$upload=true;}
	if (!$upload){
		$imgCover='<a href="#dialog" name="modal"><img id="prod-img" style="-moz-box-shadow: inset 0 0 3px 3px lightGrey;-webkit-box-shadow: inset 0 0 3px 3px lightGrey;box-shadow: inset 0 0 3px 3px lightGrey;padding: 3px;border-radius: 3px;border: 1px solid #C4C4C4;width:150px;height:100px;" src="upload/'.$path.'"></a>';
	}else{
		$imgCover='<script>$(document).ready(function(){addInput();});</script><img id="prod-img" style="margin:5px;border:3px solid #E8E8E8;width:150px;height:100px;" src="upload/'.$path.'">';
	}
	return $imgCover;
}
function getLoginType(){
	$login = null;
	if (array_key_exists('login',$_SESSION)){
		$login = $_SESSION['login'];
	}
	return $login;
}
?>
