<?php 
session_start();
include "include/database.php";
if (!isset($_SESSION['email'])){Redirect("index.php");}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
	<?php include "include/header.php";?>
	<body>
    <div id="main">

      <?php include "include/searchbox.php"; ?>
	  <div id="container" >
	   <script>
	   var qc;
	    jQuery(function() {
	     var optionsqc = {
			source: 'auto_suggest_tags.php',
			width: 514,
			};

		 qc = $('#qc').autocomplete(optionsqc);
		 });
		 $.get("include/compare_list.php?id=<?=$id;?>",function(data) {
				$("#compare-list").html(data);
				$.get("include/compare_table.php",function(data2) {
					$("#compare-table").html(data2);
				});
			//	$("#compare-list").append('<a href="javascript:void(0)" onclick="addNewToCompare()"> Add this to compare list </a>');
			//	$("#compare-list").append('<br><a href="compare.php"> Go to compare list </a>');
		 });
		 function addNewToCompareByName(name){
			name=$("#qc").val();
			$("#qc").val('');
			 $.get("include/compare_list.php?a=-1&n="+name,function(data) {
				$("#compare-list").html(data);
				$.get("include/compare_table.php",function(data2) {
					$("#compare-table").html(data2);
				});
			//	$("#compare-list").append('<a href="javascript:void(0)" onclick="addNewToCompare()"> Add this to compare list </a>');
			//	$("#compare-list").append('<br><a href="compare.php"> Go to compare list </a>');
			});
		 }
		 function remove_from_compare(id){
		  $.get("include/compare_list.php?r="+id,function(data) {
				$("#compare-list").html(data);
								$.get("include/compare_table.php",function(data2) {
					$("#compare-table").html(data2);
				});
				//$("#compare-list").append('<a href="javascript:void(0)" onclick="addNewToCompare()"> Add this to compare list </a>');
				//$("#compare-list").append('<br><a href="compare.php"> Go to compare list </a>');
			});
		 }
		
		 </script>
        
		<div id="innercontainer">
			<div class="summary" style="width:990px;">
			<span id="title">Compare items:</span>
			<div id="block"></div>
				<div id="compare-list">
				
				</div>
				<div id="block" style="margin-top:10px"></div>
				<div id="add-search-box" style="margin:0 0 0 0">
						<input type="text" class="textbx" style="width:900px;height:18px;" name="qc" id="qc" /> 
						<button onclick="addNewToCompareByName();" class="btn btn-primary start">
							<i class="icon-upload icon-white"></i>
							<span>Add</span>
						</button>	
				</div>
			
				<br>
           
            </div>
			<div class="summary" style="width:990px;">
			<table id="compare-table">
			
			</table>
			</div>
		
		

		</div>
		</div>
    </div>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
    <script src="js/jquery.tagify.js"></script>
	<script>
    $('#tags').tagify();
	</script>
	<script>
					function addFeedback(){
					$.post("process.php",{category: $("#catFeed").val() , id: '<?php echo $id; ?>',addFeedback: 'true', good: $("#goodFeed").val() , bad: $("#badFeed").val()},function(data){if (data=='redirect'){
					window.location.href='login.php?msg=af&id=<?php echo $id; ?>';
					}else{
					$(".ResultList").html(data);			
					}
					});
					}
					function confirm_add_review(fc,good2,bad2,id2){
						$.post("process.php",{category:fc , id: id2,addFeedback: 'true', good: good2 , bad: bad2},function(data){if (data=='redirect'){
					window.location.href='login.php?msg=af&id=<?php echo $id; ?>';
					}else{
					$(".ResultList").html(data);			
					}
					});
						return false;
					}
					</script>
	<script>
					function isNumber(n) {
					return !isNaN(parseFloat(n)) && isFinite(n);
						}
					function addLike(value){
					$.get("process.php", { idfeedback: value, id: "<?php echo $id;?>", addLike: "true"},function(data) {
					
					if (isNumber(data)){
					$("#"+value).text(data);
					}else{
					window.location.href=data;
					}
					});
					}
					</script>
	<script type="text/javascript">

	</script>
</body>
</html>
