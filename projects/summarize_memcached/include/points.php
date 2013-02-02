<?php
	$points=$database->query("SELECT SUM(points),pid,action FROM `points` WHERE uid = ".$uid." AND `status`='YES' GROUP BY `pid`,`action` ORDER BY SUM(points) DESC");
	$total_points=$database->query("SELECT SUM(points) FROM `points` WHERE uid = ".$uid." ");
	$tp=mysql_fetch_array($total_points);
	
	echo "<div id='points-div'>";
	echo '<span id="title" >Points:</span><span id="total-points">+'.$tp[0].'</span><div id="block"></div>';
	if (mysql_num_rows($points)<1){
		echo "<div id='notification'>You have no points.</div>";
	} else {
	echo "<table style='width:780px'>";
	while ($info=mysql_fetch_array($points)){
		$prod_data=$database->query("SELECT * FROM `product` WHERE `idproduct` = '".$info['pid']."'");
		$prod_info=mysql_fetch_array($prod_data);
		$text='';
		if ($info['action']=="feedback"){$text='For adding a new feedback on ';}
		if ($info['action']=="tag"){$text='For adding tags on ';}
		if ($info['action']=="like"){$text='For liking a feedback on ';}
		if ($info['action']=="product"){$text='For adding the new product ';}
		if ($info['action']=="question"){$text='For adding a question on ';}
		if ($info['action']=="answer"){$text='For adding an answer on ';}
		echo "<tr>";
		echo "<td style='padding-left:5px;font-size:15px;color:#555;font-weight:bold;'>
				".$text." <a href='result.php?id=".$prod_info['idproduct']."'>".$prod_info['name']."</a>
			</td><td style='text-align:right;color:#F53939;font-size:17px;font-weight:bold;'>					
			  + ".$info[0]."
			 </td></tr><tr><td colspan='3'><hr style='margin: 0px;'></td>";
		echo "</tr>";
	}
	echo "</table>";
	}
	echo "</div>";
?>