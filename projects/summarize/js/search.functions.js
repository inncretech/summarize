/*$('#global-search').typeahead({
    source: function (query, process) {
        data = ["red", "blue", "green", "yellow", "brown", "black"];
		
		process({source: data});
    },
    updater: function (item) {
        // implementation
    },
    matcher: function (item) {
        // implementation
    },
    sorter: function (items) {
        // implementation
    },
    highlighter: function (item) {
      var regex = new RegExp( '(' + this.query + ')', 'gi' );
	  return item.replace( regex, "<strong>$1</strong>" );
    },
	items: 5,
	minLenght: 2
});*/



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
		$("#global-search-btn").attr('onclick',"window.location.href='product.php?id="+map[obj]+"';");
    }
	
});