



$('#global-search').keyup(function(){	
	$("#global-search-btn").attr('onclick','window.location.href="'+site_root+'/search.php?query='+$("#global-search").val()+'";return false;');

});
$('#advanced-search').keyup(function(){

	if ($(this).val()!='') render.advancedSearchMenu($(this).val());
});
if ($('#addCompareValue').length > 0){
$('#addCompareValue').autocomplete({
			source: function(request, response) {
			source_data = [];
			map = {};	
						$.ajax({
							
							url: site_root+"/backend/ajax.get/get_search_data.php",
							data: {query: request.term },
							dataType: "json",
							contentType: "application/json",
							success: function(data) {
								
								response($.map(data, function(item) {
									
									map[item.title] = item.seo_title;
									return {
										label: item.title,
										value: item.title,
										seo_title: item.seo_title,
										type: item.type,
									}
								}));
							}
						});},
			position: { of: $('#addCompareValue') },
			select: function(event, ui) { },
			open: function(event, ui) {
            $(this).autocomplete("widget").css({
                "width": "auto"
            })}, 
		});
}

if ($('#global-search').length > 0){
$('#global-search').autocomplete({
			source: function(request, response) {
			source_data = [];
			map = {};	
						$.ajax({
							
							url: site_root+"/backend/ajax.get/get_search_data.php?tag=true",
							data: {query: request.term },
							dataType: "json",
							contentType: "application/json",
							success: function(data) {
								
								response($.map(data, function(item) {
									
									map[item.title] = item.seo_title;
									return {
										label: item.title,
										value: item.title,
										seo_title: item.seo_title,
										type: item.type,
									}
								}));
							}
						});},
			open: function(event, ui) {
            $(this).autocomplete("widget").css({
                "width": "auto"
            })},
			position: { of: $("#global-search") },
			select: function(event, ui) { if (ui.item.type=="product") $("#global-search-btn").attr('onclick',"window.location.href='"+site_root+"/product/"+ui.item.seo_title+"';return false;"); else { $("#global-search-btn").attr('onclick','window.location.href="'+site_root+'/search.php?query='+ui.item.value+'";return false;'); } },

		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			  return $( "<li>" )
				.append( "<a>" + item.label + "<b style='float:right;padding-left:10px'>" + item.type + "</b>" )
				.appendTo( ul );
			};
}

/*
$('#fb-friend-name').autocomplete({
			source: function(request, response) {
					
						$.ajax({
							
							url: site_root+"/backend/ajax.get/get_fb_friend_list.php",
							data: {query: request.term },
							dataType: "json",
							contentType: "application/json",
							success: function(data) {
								
								response($.map(data, function(item) {
									
									
									return {
										label: item.friend_name,
										value: item.friend_name,
										id: item.friend_id
									}
								}));
							}
						});},
			position: { of: $('#fb-friend-name') },
			select: function(event, ui) {$('#fb-friend-id').val(ui.item.id); },
			open: function(event, ui) {
            $(this).autocomplete("widget").css({
                "width": "auto"
            })}, 
		});*/


