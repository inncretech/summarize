<?php
	$follows=$database->query("Select * from notifications_follow where uid='".$uid."'");
	$q="";
	while ($info=mysql_fetch_array($follows)){
			$q=$q."(`idproduct`='".$info['product']."' and `date`>'".$info['date']."') OR ";
	}
	echo "<div id='notification-div'>";
	echo '<div id="title">Notifications:</div><div id="block"></div>';
	$follows=$database->query("select * from notifications where $q 1=2 ORDER BY `date` DESC;");
	if (mysql_num_rows($follows)<1){
		echo "<div id='notification'>You have no new notifications.</div>";
	} else {
	echo "<table width='780' style='float:left;'>";
	while ($info=mysql_fetch_array($follows)){
		$pdata=$database->query("select * from product where idproduct='".$info['idproduct']."';");
		$pinfo=mysql_fetch_array($pdata);
		$udata=$database->query("select * from users where uid='".$info['uid']."';");
		$uinfo=mysql_fetch_array($udata);
		echo "<tr>";
		echo "<td style='color:#555;font-weight:bold;'>					
				<div id='not' class='notification".$info['id']."'   >
					<img style='height:25px;margin-right:5px;border:2px solid whitesmoke;' src='".$uinfo['profileimageurl']."'><a title='".$info['date']."' href='user.php?uid=".$info['uid']."'>".$info['username']."</a> ".$info['text']." <a title='".$info['date']."' href='result.php?id=".$info['idproduct']."'>".$pinfo['name']."</a>
				
			
					<a id='action' href='javascript:void(0);' title='".$info['date']."' onclick='hideolderthan(\"".$info['idproduct']."\",\"".$info['date']."\",\"".$info['id']."\");' ><img src='images/x.png' style='margin-top:-3px;'></a>
</div>
			</td></tr><tr><td colspan='3'><hr style='margin: 0px;'></td>";
		echo "</tr>";
	}
	echo "</table>";
	}
	echo "</div>";
?>
<script type="text/javascript">
function hideolderthan(id,date,idnot){
		$("#not a").each(function(index,domel){
				if (domel.title<=date) 
				{
					$(domel).parent().parent().parent().fadeOut(function(){refNot();});	
				}
		});
		$.get('process.php?action=0&p='+id, function(data) {
			$.get('process.php?action=1&p='+id+"&date="+date, function(data) {
			});
		});
		
	}
function refNot()
{
	$.get("include/getNotCount.php",function(data){$("#noti-count").text(data);});
}
</script>