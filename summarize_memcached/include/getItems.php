<?php
include "database.php";
$data = $database->query("SELECT SUM(thumb),idproduct FROM `feedback` WHERE `type`='good' AND `category`='".$_POST['cat']."' GROUP BY `idproduct` ");
$items = array();
$aux=0;
while ($info = mysql_fetch_array($data)){
	$p = $database->query("SELECT * FROM `product` WHERE `idproduct`='".$info['idproduct']."' AND `tags` LIKE '%".$_POST['tag']."%' ");
	if (mysql_num_rows($p)>0)
	{
		$p_info = mysql_fetch_array($p);
		$id=$p_info['idproduct'];
		echo '<div class="summary" style="height:243px;width:472px;padding-bottom: 0px;"><div style="font-weight:bold;font-size:15px;color:#555;padding-bottom:5px;">'.$p_info['name'].'</div>';
		$upload=false;
		if (file_exists("../upload/".$id.".jpg"))
		{ 
		$path=$id.".jpg";
		}  
		else  
		{  
		if (file_exists("../upload/".$id.".png")){$path=$id.".png";}else{$path="no-pic.jpg";$upload=true;}
		} 
		$aux=explode(" ",$p_info['name']);
		$aux=implode("-",$aux);
		echo "<img onclick=\"window.location.href='".$aux."';\" style='cursor:pointer;border:3px solid #E8E8E8;width:150px;height:100px;margin-bottom:10px;' src='upload/".$path."'>";
		echo "<div style='float:right;width:310px;'>";
		$tags = explode(',',$p_info['tags']);
		shuffle($tags);
		$count=0;
		foreach ($tags as &$tag){
			$count++;
			$tag=ltrim(rtrim($tag));
			echo "<span id='tag' style='margin-bottom:5px;'><a style='text-decoration:none;color:white;' href='similar.php?tag=$tag'>".$tag."</a></span>";
			if ($count==6) break;
		}
		echo "</div>";
		echo "<div style='min-height:54px;'>".substr($p_info['comment'], 0, 210)."...<a href='".$aux."'>more</a></div>";
		$user_data=$database->query("SELECT * FROM users WHERE uid=".$p_info['userID']);
		$user_info=mysql_fetch_array($user_data);
		$thumb_data=$database->query("SELECT SUM(thumb) FROM feedback WHERE idproduct= '".$id."' AND type='good' ");
		$thumb_info=mysql_fetch_array($thumb_data);
		$thumb_data_bad=$database->query("SELECT SUM(thumb) FROM feedback WHERE idproduct= '".$id."' AND type='bad' ");
		$thumb_info_bad=mysql_fetch_array($thumb_data_bad);
		if ($thumb_info[0] == NULL) {$thumb_info[0] = 0; }
		if ($thumb_info_bad[0] == NULL) {$thumb_info_bad[0] = 0; }
		echo "<div class='prod-poster' style='height:20px;'>
			 <span class='thumbUp' style='float:left;'> ".$thumb_info[0]." Positive </span>
			 <span class='thumbDown' style='float:left;'> ".$thumb_info_bad[0]." Negative</span>
			 <span style='float:right;'> Added by <a href='user.php?uid=".$user_info['uid']."'>".$user_info['fname']." ".$user_info['lname']."</a> </span>
			 </div>";
        echo '</div>';
	}
}
?>