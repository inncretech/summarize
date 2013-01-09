<?php 
session_start(); 
include "include/database.php";
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
			  <span id="title"> Enter tags to get experts </span>
			  <div id='block' style="margin-top:5px;"></div>
              <div style='border:2px solid #DADADA;padding-left:5px;'><textarea id="tags" >sample tag</textarea></div>
			  
            <div id="experts" style="margin-top:5px;">
				
			</div>
            </div>
           
          </div>
        </div>
       
	  </div>
    
<script>
function getExperts() {
	$.post("include/getExperts.php",{tags: $('#tags').tagify('serialize')},function (data){$("#experts").html(data);     });
}

var TagArea = $('#tags').tagify();

	TagArea.tagify('inputField').autocomplete({
											source: [ <?php 
											$data=$database->query("SELECT * FROM `product`");
											$unique_tags = array();
											while ($info=mysql_fetch_array($data))
											{
												$tags=explode(",",$info['tags']);
												$unique_t = array();
												foreach ($tags as &$tag) 
												{
													array_push($unique_t,str_replace(" ", "", $tag));
												}
												$unique_tags = array_merge($unique_tags,$unique_t);
											}
											$unique_tags=array_unique($unique_tags);
											$str=null;
											foreach ($unique_tags as &$tag) 
											{
												$tag = str_replace(" ", "", $tag);
												$str=$str.'"'.$tag.'",';
											}
											$str=substr_replace($str ,"",-1);
											echo $str;
											?>],
											position: { of: TagArea.tagify('containerDiv') },
											select: function(event, ui) {setTimeout(function() { TagArea.tagify('add');getExperts();},10);},
											close: function(event, ui) {},
	});
</script>
</body>
</html>
