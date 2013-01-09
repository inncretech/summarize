<?php 
session_start(); 

include "include/database.php";
if (!isset($_SESSION['email'])){ Redirect('index.php');}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include "include/header.php"; ?>
	<body>
    <div id="main">

       <?php include "include/searchbox.php"; ?>
      <div style="background-color:#289BDB;width:100%;height:3px;"></div>
      <div id="container" >
        <div id="innercontainer">
		
          <div class="summary"  style="width:990px;margin-bottom:50px;">
		  <div id='title'>Dashboard</div>
		  <div id='block'></div>
           
				<?php
					$follows=$database->query("Select * from notifications_follow where email='".$_SESSION['email']."'");
					$q="";
					while ($info=mysql_fetch_array($follows)){
							$q=$q."(`idproduct`='".$info['product']."' and `date`>'".$info['date']."') OR ";
					}
					$follows=$database->query("select * from notifications where $q 1=2 ORDER BY `date` DESC;");
					if (mysql_num_rows($follows)<1){
						echo "<div id='notification'>You have no new notifications.</div>";
					} else {
					echo "<table width='1250'>";
					while ($info=mysql_fetch_array($follows)){
						echo "<tr>";
						echo "<td style='border-right:2px solid #E0E0E0;'>					
								<div id='not' class='notification".$info['id']."'   >
									<a title='".$info['date']."' id='notification' href='result.php?id=".$info['idproduct']."'>
									<a href='user.php?uid=".$info['uid']."'>".$info['username']."</a> ".$info['text']."</a> 
								</div>
							 </td>
							 <td style='padding-left:5px;'>
								<div id='not' class='notification".$info['id']."'   > 
									<a id='action' href='javascript:void(0);' title='".$info['date']."' onclick='hideolderthan(\"".$info['idproduct']."\",\"".$info['date']."\",\"".$info['id']."\");' >Hide older than this </a>
								</div>
							</td>";
					    echo "</tr>";
					}
					echo "</table>";
					}
				?>
				<script type="text/javascript">
					function hideolderthan(id,date,idnot){
							$("#not a").each(function(index,domel){
									alert(date+" "+domel.title+" "+(domel.title<=date));
									if (domel.title<=date) 
									{
										$(domel).parent().parent().parent().fadeOut(function(){refNot();});	
									}
							});
							$.get('include/follow_button.php?action=0&p='+id, function(data) {
								$.get('include/follow_button.php?action=1&p='+id+"&date="+date, function(data) {
								});
							});
							
						}
					function refNot()
					{
						$.get("include/getNotCount.php",function(data){$("#noti-count").text(data);});
					}
				</script>
	  </div>
    </div>
</body>
</html>
