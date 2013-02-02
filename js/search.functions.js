
$("#global-search").keyup(function(event){

    if(event.keyCode == 13){
	
        $("#global-search-btn").click();
    }
});

$('#global-search').keyup(function(){
	$("#global-search-btn").attr('onclick',"render.search('"+$(this).val()+"');return false;");
});

$('#addCompareValue').typeahead({source: function (typeahead, query) {
		source_data = [];
		map = {};
		
		$.ajax({
			url: "backend/ajax.get/get_search_data.php",
			data: { 
				query: query 
			},
			type: "POST",
			dataType: 'json',
			success: function(data, textStatus, xhr) {
				$.each(data, function (i, value) {
					//alert(value.title);
					map[value.title] = value.product_id;
					source_data.push(value.title);
				});
				typeahead.process(source_data);
			},
			error: function(xhr, textStatus, errorThrown) {
				alert(textStatus);
			}
		});
	},
	onselect: function (obj) {
		
		//$("#global-search-btn").attr('onclick',"window.location.href='product.php?id="+map[obj]+"';return false;");
    }
	
});

$('#global-search').typeahead({source: function (typeahead, query) {
		source_data = [];
		map = {};
		
		$.ajax({
			url: "backend/ajax.get/get_search_data.php",
			data: { 
				query: query 
			},
			type: "POST",
			dataType: 'json',
			success: function(data, textStatus, xhr) {
				$.each(data, function (i, value) {
					//alert(value.title);
					map[value.title] = value.product_id;
					source_data.push(value.title);
				});
				typeahead.process(source_data);
			},
			error: function(xhr, textStatus, errorThrown) {
				alert(textStatus);
			}
		});
	},
	onselect: function (obj) {
		//alert(obj);
		$("#global-search-btn").attr('onclick',"window.location.href='product.php?id="+map[obj]+"';return false;");
    }
	
});