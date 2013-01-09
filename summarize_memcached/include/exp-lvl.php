<?php
$points_data=$database->query("SELECT SUM(points),pid FROM `points` WHERE `uid`='".$uid."' GROUP BY `pid`");
$tags = array();

while ($points_info=mysql_fetch_array($points_data)) {
	
	$pdata=$database->query("SELECT * FROM `product` WHERE `idproduct` = '".$points_info['pid']."' ");
	$pinfo=mysql_fetch_array($pdata);
	$ptag=explode("," , $pinfo['tags']);
	foreach ($ptag as &$tag) {
		
		$tags[str_replace(" ", "",$tag)] += $points_info[0];
		
	}
}


echo "<div id='expert-div' style='overflow:hidden ;float:left;display:none;'>";
echo "<span id='title' style='font-size: 1.6em;'>Expert level:</span><span id='tag' style='margin-bottom:5px;'>Expert</span><span id='tag' style='margin-bottom:5px;background-color:#F03D25;'>Not Expert</span><span id='title' style='font-size: 1.4em;'>Click tags to see user activity on them.</span><div id='block'></div>";
$ok=false;
foreach ($tags as $k => $v){
$ok=true;
$color="#3D8EFF";
if($v>=EXPERT_POINTS){}else{$color="#F03D25";}
echo "<span onclick='fillActivity(\"".$data['uid']."\",\"".$k."\")' id='tag' style='cursor:pointer;background-color:".$color.";' >".$v." points on ".$k."</span></span>";
}
if(!$ok){echo "<div id='notification'>This user is not an expert on any tag.</div>";}
echo "</div>";
?>
