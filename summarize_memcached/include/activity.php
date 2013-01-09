<?php 
$d = $database->query("SELECT * FROM activity WHERE `uid` = '".$uid."' ORDER BY date DESC LIMIT 0,10");
$recent = array();
$aux = 0;

while ($i = mysql_fetch_array($d)){
$a=explode(" ",$i['pname']);
$a=implode("-",$a);
$recent[$aux]['pid']=$i['pid'];
$recent[$aux]['link']=$a;
$recent[$aux]['news']=$i['comment'];
$recent[$aux]['date']=$i['date'];
$recent[$aux]['type']=$i['type'];
$recent[$aux]['pname']=$i['pname'];
$aux++;
}

echo "<div id='activity-div'>";
echo '<div id="title">Recent Activity:</div><div id="block"></div>';
for ($i=0;$i<$aux;$i++){
	if (file_exists("upload/".$recent[$i]['pid'].".jpg")){$path=$recent[$i]['pid'].".jpg";}else{$path="no-pic.jpg";
	if (file_exists("upload/".$recent[$i]['pid'].".png")){$path=$recent[$i]['pid'].".png";}else{$path="no-pic.jpg";}}
	echo "<div style='margin-bottom:5px;padding:5px;'><img src='upload/".$path."' class='follow-img'><span style='margin-left:5px;font-weight:bold;font-size:15px;cursor:pointer;color: #08C;margin-right:5px;' onclick=\"window.location.href='".$recent[$i]['link']."';\">".$recent[$i]['pname']."</span><b>".$recent[$i]['type']."</b> : ".$recent[$i]['news']."<span style='font-size:12px;'> ( ".$recent[$i]['date']." )</span> </div><hr style='margin: 0px;'>";
}
echo "</div>";
?>
