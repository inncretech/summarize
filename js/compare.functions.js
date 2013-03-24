var compare = new function(){
	var parent = this;
	this.set = function(value){
		$.post(site_root+"/backend/ajax.post/add_product_to_compare.php",{title:value},function(data){
			similar_base_product = data;
			parent.refresh_table();
			parent.refresh_list();
		});
	}
	
	this.remove = function(value){
		$.post(site_root+"/backend/ajax.post/remove_product_from_compare.php",{title:value},function(data){	
			parent.refresh_list();
			parent.refresh_table();
		});
	}
	
	this.getSimilarItems = function(){
		if(typeof similar_base_product !== 'undefined'){
			$.post(site_root+"/backend/ajax.get/get_similar_products.php",{product_id:similar_base_product},function(data){	
				render.similarProducts(data);
				
			});
		}
	}
	
	this.refresh_list = function (){
		$.post(site_root+"/backend/ajax.get/compare_product_list.php",function(data){
			parent.getSimilarItems();
			render.compare_list(data);
			parent.refresh_table();
			$("#addCompareValue").val('');
		});
	}
	this.listen = function (value){
		$(value).click(function(){
			showCompareDisplay();
			parent.set($("#addCompareValue").val());
			compare.refresh_table();
		});
	} 
	
	this.refresh_table = function (){
		$.post(site_root+"/backend/ajax.get/compare_product_table_data.php",function(data){
			//alert(data);
			//$("#compare-container table").html(data);
			
			render.compare_table(data);
		});
	}
}

function hideCompareDisplay(){
	$('#compare-tab-content').hide();
}
function showCompareDisplay(){
	$('#compare-tab-content').show();
}

if ((typeof compareItems !== 'undefined')&&(compareItems)){
	compare.listen(".compare-button");
	compare.refresh_table();
	compare.getSimilarItems();
}