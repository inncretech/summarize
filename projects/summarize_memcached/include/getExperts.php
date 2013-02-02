<?php 
include "database.php";
$tags = explode("," , $_POST['tags']);
$gData = array();
$first = true;
foreach ($tags as &$tag)
{
	$aData =array();
	$fData =array();
	$aux = 0;
	$data=$database->query("SELECT `idproduct` FROM `product` WHERE `tags` LIKE '%".$tag."%'");
	
	while ($info=mysql_fetch_array($data))
	{
		$p_data=$database->query("SELECT SUM(points),uid FROM `points` WHERE `pid` = '".$info['idproduct']."' GROUP BY `uid` ");
		while ($i_data=mysql_fetch_array($p_data)){
			$aData[$aux]['points']=$i_data[0];
			$aData[$aux]['uid']=$i_data[1];
			$aux +=1;
		}
	}
	for ($i=0; $i<$aux; $i++){
	$fData[$aData[$i]['uid']] += $aData[$i]['points'];
	}
	if (!$first){
		foreach ($gData as $k1 => $v1){
			$ok=false;
			foreach ($fData as $k2 => $v2) {
				if ($k1 == $k2) {
					if ($v2 >= EXPERT_POINTS) {$ok= true;}
				}	
			}
			if ($ok==false) {unset($gData[$k1]); }
		}
	}
	else
	{
		foreach ($fData as $k2 => $v2) {
			if ($v2 >= EXPERT_POINTS) {$gData[$k2]=$v2;}			
		}
		$first=false;
	}
}
foreach ($gData as $key => $value) {
	$data=$database->query("SELECT * FROM `users` WHERE `uid`='".$key."' ");
	$info = mysql_fetch_array($data);
	echo "<a href='user.php?uid=".$info['uid']."'>".$info['username']."</a><br>";
}


?>