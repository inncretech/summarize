<?php 
session_start(); 
include "include/database.php";

$id=$_GET['id'];
$data=$database->query("select * from product where idproduct='$id'");
$tagsr=mysql_fetch_array($data);
$prod_name=$tagsr['name'];
$tagsr=$tagsr['tags'];
$tags=explode(",",$tagsr);
$expertsraw="";
foreach( $tags as $tag){
		$tag=trim($tag);
		$exp=$database->getExperts($tag);
		while ($e=mysql_fetch_array($exp)){
			$a['tag']=$tag;
			$a['uid']=$e['uid'];
			//$a['count']=$e['count'];
			$a['points']=$e['points'];
			if ($a['points']>=EXPERT_POINTS) $expertsraw [] = $a;
		}
	}

$experts="";
foreach ($expertsraw as $e){	
		if (!isset($experts[$e['uid']])){
				$experts[$e['uid']]['tags']=$e['tag'];
				$experts[$e['uid']]['points']=$e['points'];
		} else {
				$experts[$e['uid']]['tags'] = $experts[$e['uid']]['tags'].",".$e['tag'];
				$experts[$e['uid']]['points'] = $experts[$e['uid']]['points']+$e['points'];
		}
}
function array_sort($arr){
    if(empty($arr)) return $arr;
    foreach($arr as $k => $a){
        if(!is_array($a)){
            arsort($arr); // could be any kind of sort
            return $arr;
        }else{
            $arr[$k] = array_sort($a);
        }
    }
    return $arr;
}
$experts=array_sort($experts);
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
              <span id="title">Experts for <a href='result.php?id=<?=$id;?>'><?=$prod_name;?></a></span>
			  <div id='block'></div>
            <?php
			echo "<table id='expert-table'><tr><th>User</th><th>Points</th><th>Tags</th></tr>";
			foreach ($experts as $uid=>$expert){
				$tags=explode(',',$expert['tags']);
				$str=null;
				$user_data=$database->query("SELECT * FROM `users` WHERE `uid` = '".$uid."'");
				$user_info=mysql_fetch_array($user_data);
				foreach ($tags as &$tag){
				$str.="<span id='tag'>".$tag."</span>";
				}
				echo "<tr><td><a href='user.php?uid=".$uid."'><img src='".$user_info['profileimageurl']."' style='border: 2px solid silver;margin-right:3px;' width='30' height='30'>".$user_info['username']."</a></td><td>".$expert['points']."</td><td>".$str."</td></tr>";
			}
			echo "</table>";
			?>
            </div>
           
          </div>
        </div>
       
	  </div>
    

</body>
</html>
