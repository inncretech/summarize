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
 });
 function addNewToCompareByName(name){
	name=$("#qc").val();
	$("#qc").val('');
	 $.get("include/compare_list.php?a=-1&n="+name,function(data) {
		$("#compare-list").html(data);
		$.get("include/compare_table.php",function(data2) {
			$("#compare-table").html(data2);
		});
	});
 }
 function remove_from_compare(id){
  $.get("include/compare_list.php?r="+id,function(data) {
		$("#compare-list").html(data);
						$.get("include/compare_table.php",function(data2) {
			$("#compare-table").html(data2);
		});
	});
 }
 $.get("include/compare_list.php?id=<?=$id;?>",function(data) {
				$("#compare-list").html(data);
		 });
 function addNewToCompare(){
	 $.get("include/compare_list.php?a=<?=$id;?>&n=<?=$name;?>",function(data) {
		$("#compare-list").html(data);	
	});
 }
 function remove_from_compare(id){
  $.get("include/compare_list.php?r="+id,function(data) {
		$("#compare-list").html(data);
	});
 }
