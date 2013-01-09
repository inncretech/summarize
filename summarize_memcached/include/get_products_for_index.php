	<?php
		$page=($_GET['page']-1)*6;
		$page2=6;
		include "database.php";
		if (isset($_GET['likeid'])){
			$id=$_GET['likeid'];
			$data=$database->query("SELECT * FROM product WHERE idproduct='".$id."'");
			$info=mysql_fetch_array($data);
			$tags=$info['tags'];
			$terms=explode(",",$tags);
			$q = null;
			$q = " AND (";
			foreach ($terms as &$term) {
				$q .= " t1.name LIKE '%".$term."%' or t1.tags like '%".$term."%' or ";
				}
			$q = substr_replace($q ,"",-3);
			$q .= ")";
		}
		if (isset($_GET['tag'])){
			$tag=$_GET['tag'];
			$q = " AND (t1.name LIKE '%".$tag."%' or t1.tags like '%".$tag."%') ";
		}
		if (isset($_GET['name'])){
			$name=$_GET['name'];
			$q = " AND (t1.name LIKE '%".$name."%') ";
		}
		$data=$database->query("select *,t1.comment as 'com' from product as t1  left join feedback as t2 on t1.idproduct=t2.idproduct where t1.idproduct=t2.idproduct $q GROUP BY t1.idproduct order by t1.photo DESC, (select sum(thumb) from feedback where idproduct=t1.idproduct)  DESC,  LENGTH(t1.tags)-LENGTH(REPLACE(t1.tags,',','')) DESC limit $page,$page2") or die(mysql_error());
		while($info=mysql_fetch_array($data)){
		$id=$info['idproduct'];
		echo '<div class="summary" style="height:243px;width:472px;padding-bottom: 0px;"><div style="font-weight:bold;font-size:15px;color:#555;padding-bottom:5px;">'.$info['name'].'</div>';
		$upload=false;
		if (file_exists("../upload/".$id.".jpg"))
		{ 
		$path=$id.".jpg";
		}  
		else  
		{  
		if (file_exists("../upload/".$id.".png")){$path=$id.".png";}else{$path="no-pic.jpg";$upload=true;}
		} 
		$aux=explode(" ",$info['name']);
		$aux=implode("-",$aux);
		echo "<img onclick=\"window.location.href='".$aux."';\" style='cursor:pointer;-moz-box-shadow: inset 0 0 3px 3px lightGrey;-webkit-box-shadow: inset 0 0 3px 3px lightGrey;box-shadow: inset 0 0 3px 3px lightGrey;padding: 3px;border-radius: 3px;border: 1px solid #C4C4C4;width:150px;height:100px;margin-bottom:10px;' src='upload/".$path."'>";
		echo "<div style='float:right;width:310px;'>";
		$tags = explode(',',$info['tags']);
		shuffle($tags);
		$count=0;
		foreach ($tags as &$tag){
			$count++;
			$tag=ltrim(rtrim($tag));
			echo "<span id='tag' style='margin-bottom:5px;'><a style='text-decoration:none;color:white;' href='similar.php?tag=$tag'>".$tag."</a></span>";
			if ($count==6) break;
		}
		
		echo "</div>";
		echo "<div class='min-prod-text'>".substr($info['com'], 0, 180)."...<a href='".$aux."'>more</a></div>";
		$user_data=$database->query("SELECT * FROM users WHERE uid=".$info['userID']);
		$user_info=mysql_fetch_array($user_data);
		$thumb_data=$database->query("SELECT SUM(thumb) FROM feedback WHERE idproduct= '".$id."' AND type='good' ");
		$thumb_info=mysql_fetch_array($thumb_data);
		$thumb_data_bad=$database->query("SELECT SUM(thumb) FROM feedback WHERE idproduct= '".$id."' AND type='bad' ");
		$thumb_info_bad=mysql_fetch_array($thumb_data_bad);
		if ($thumb_info[0] == NULL) {$thumb_info[0] = 0; }
		if ($thumb_info_bad[0] == NULL) {$thumb_info_bad[0] = 0; }
		echo "<div class='prod-poster' style='height:15px;'>
			 <span class='thumbUp' style='float:left;'> ".$thumb_info[0]." Positive </span>
			 <span class='thumbDown' style='float:left;'> ".$thumb_info_bad[0]." Negative</span>
			 <span style='float:right;'> Added by <a href='user.php?uid=".$user_info['uid']."'>".$user_info['fname']." ".$user_info['lname']."</a> </span>
			 </div>";
        echo '</div>';
	}
?>