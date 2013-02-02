var compare = new function(){
	var parent = this;
	this.set = function(value){
		$.post("backend/ajax.post/add_product_to_compare.php",{title:value},function(data){
			
			parent.refresh_list();
		});
	}
	this.remove = function(value){
		$.post("backend/ajax.post/remove_product_from_compare.php",{title:value},function(data){	
			parent.refresh_list();
			compare.refresh_table();
		});
	}
	
	this.refresh_list = function (){
		$.post("backend/ajax.get/compare_product_list.php",function(data){
			//alert(data);
			render.compare_list(data);
			compare.refresh_table();
			$("#addCompareValue").val('');
		});
	}
	this.listen = function (value){
		$(value).click(function(){
			parent.set($("#addCompareValue").val());
			compare.refresh_table();
		});
	}
	
	this.refresh_table = function (){
		$.post("backend/ajax.get/compare_product_table_data.php",function(data){
			//alert(data);
			//$("#compare-table").html(data);
			
			render.compare_table(data);
		});
	}
}
if(typeof product_id !== 'undefined'){
	compare.listen("#addCompareBtn");
	compare.refresh_table();
}