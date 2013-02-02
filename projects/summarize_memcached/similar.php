<?php 
session_start();
include "include/database.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include "include/header.php";?>
	<body>
    <div id="main">

       <?php include "include/searchbox.php"; ?>
      <div id="container" >
        <div id="innercontainer">
          <div class="summary" style="width:990px;"> 
			  <span id="title"> Simillar Products: </span>
			  <div id='block' style="margin-top:5px;"></div>
			  </div>
					<div id="innercontainer2">
					</div>
					<?php
					/*
					$term=$_GET['tag'];
					$qstring = "SELECT * FROM product WHERE name LIKE '%".$term."%' or tags like '%".$term."%'";
					$data=$database->query($qstring);
					if (mysql_num_rows($data)<1){
						echo "No similar products found.";
					}
					
					while ($info=mysql_fetch_array($data)){
					$thumbs_data=$database->query("SELECT * FROM feedback WHERE `idproduct`='".$info['idproduct']."'");
					$up=0;
					$down=0;
					while ($thumbs=mysql_fetch_array($thumbs_data)){
						if ($thumbs['type']=="good") { $up = $up+1;}
						if ($thumbs['type']=="bad")  { $down = $down+1;}
					}
						echo "<div id='comment-good' style='margin-top:5px;background-color:whiteSmoke;'><a id='compare-item' href='result.php?id=".$info['idproduct']."'  title='".$info['tags']."' ><span style='margin-top:6px;color:#555;'>".$info['name']."</span><div style='float:right;color:#707070;height:20px;margin-top: -2px;'><div style='float:left;margin-top: 2px;color:#68C2DC;padding-right:5px;border-right:2px solid grey;'>".$up."</div><div style='float:left;margin-top: 2px;margin-right: 5px;margin-left: 5px;color:red'>".$down."</div></div></a></div> ";
					}
					*/
					?>
			
          </div>
        </div>
    </div>

   <script type="text/javascript">
		var page = 1,
		  loading = false;
			$.get('include/get_products_for_index.php?page='+page, function(data) {
				$("#innercontainer2").append(data);
				loading=false; 
			});
	  function nearBottomOfPage() {
		return $(window).scrollTop() > $(document).height() - $(window).height() - 100;
	  }

	  $(window).scroll(function(){
		if (loading) {
		  return;
		}

		if(nearBottomOfPage()) {
		  loading=true;
		  page++;
			$.get('include/get_products_for_index.php?page='+page+"&tag=<?=$_GET['tag'];?>", function(data) {
				$("#innercontainer2").append(data);
				loading=false;
			});
		}
	  });

	</script>
</body>
</html>
