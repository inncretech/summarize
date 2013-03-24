var categoryList = [];
var compareMap   = [];
var base_compare_product;
var render = new function() {
	//this.type = "class";
	var highestRatedLimit  = 0;
	var mostViewedLimit	   = 0;
	var recentlyAddedLimit = 0;
	
	this.discuss = function (data) {
		
		var code ='';
		obj = JSON.parse(data);
		$.each(obj, function(key, val) {
			code +='<li>';
			code +='<a href="#" onclick="return false;" class="btn btn-link" style="padding-left: 0;font-weight: bold;color: #555;" data-toggle="collapse" data-target="#faq'+key+'">'+val.question.question_text+'</a>';
			code +='<div class="collapse" id="faq'+key+'" >';
			code +='<div id="answerAddForm'+val.question.question_id+'" style="width:90%;">';
			$.each(val.answers, function(index, answer) {
				code +='<div><span style="position: relative;padding-right: 10px;top: 10px;"><i style="cursor:pointer;" class="icon-chevron-up" onclick="discuss.rateAnswer(\''+answer.answers_id+'\',0);"></i><br><i style="cursor:pointer;" class="icon-chevron-down" onclick="discuss.rateAnswer(\''+answer.answers_id+'\',1);"></i></span><a href="'+site_root+'/member/'+answer.seo_title+'">'+answer.login+'</a>: <span id="answerText'+answer.answers_id+'">'+answer.answer_text+'</span><span id="ansrating'+answer.answers_id+'" style="float:right;">'+answer.total_likes+'/'+answer.total_unlikes+'</span></div>';
			});
			code +='</div><br>';
			code +='<div class="input-append" >';
            code +='<input class="span6" id="answerInput'+val.question.question_id+'" type="text" placeholder="Answer this question!">';
            if (member_login){
				code +='<a href="#"  class="btn"  onclick="discuss.addAnswer(\''+val.question.question_id+'\');return false;" type="button">Submit</a>';
            }else{
				code +='<a href="#signInModal" data-toggle="modal"  class="btn" onclick="discuss.addAnswer(\''+val.question.question_id+'\');return false;" type="button">Submit</a>';
			}
			code +='</div>';
			code +='</li>';
		});
		$("#questionArea").html(code);		
	};
	
	this.compare_table = function (data) {
		
		$("#compare-items div").html('');
		var ok = true;
		try {
			JSON.parse(data);
		} catch (e) {
			ok = false;
		}
		
		if (ok){
			
			var colums 	= new Array();
			var code  	= '';
			var aux 	= 1;
			
			obj = JSON.parse(data);
			var category = new Array();
			$.each(obj, function(key, val) {
				$.each(val.category, function(name, thumbs) {
					category.push(name);
				});
			});
			category = category.unique();
			colums[0]  = '';
			colums[0] +='<p><b>Product</b></p>';
			
			$.each(category, function(index, value) {
				colums[aux]  = '';
				colums[aux] +='<p><span style="cursor:pointer;float:right;font-size:20px;color: rgb(170, 170, 170);margin-top:1px;margin-right:5px;" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);">&#215;</span><b style="margin-left:5px;">'+value+'</b></p>';
				aux++;
			});
			row = 0;
			
			$.each(obj, function(title, info) {
				compareMap[row] = new Array();
			
				aux = 0;
				compareMap[row][aux] = 0;
				var style ='';
				//if (info.product_id == base_compare_product) style='background-color:rgb(169, 201, 245);color:white;'
					colums[aux] += '<p class="compare-row-'+row+'" data-row-index="'+row+'" data-column-index="'+aux+'" style="'+style+'margin-bottom:0px;position:relative;">'+title+'</p>';   
				aux++;
				$.each(category, function(index, value) {
					
					var thumbs_up 	= "N";
					var thumbs_down = "A";
					$.each(info.category, function(name, val) {
						if ( name == value){thumbs_up = val.thumbs_up;thumbs_down = val.thumbs_down;}
					});
					colums[aux] += '<p class="compare-row-'+row+'" data-row-index="'+row+'" data-column-index="'+aux+'" data-compare-value="'+(parseInt(thumbs_up)+parseInt(thumbs_down))+'" style="'+style+'margin-bottom:0px;position:relative;"><a class="btn btn-success" style="color: white;font-weight: normal;margin-top: 2px;">'+thumbs_up+'</a><a class="btn btn-danger" style="margin-top: 2px;color: white;font-weight: normal;">'+thumbs_down+'</a></p>';
					compareMap[row][aux] = new Array();
					compareMap[row][aux]["value"] = isNaN(parseInt(thumbs_up)+parseInt(thumbs_down)) ? 0 : (parseInt(thumbs_up)+parseInt(thumbs_down)) ;
					compareMap[row][aux]["index"] = row;
					
					aux++;
				});
				
				row++;
			});
			var arr_colums = new Array();
			for (var i=0;i<colums.length;i++)
			{
				arr_colums[i] 					= new Array();
				arr_colums[i]['data'] 			= colums[i];
				arr_colums[i]['null_count'] 	= 0;
				$(colums[i]+" p").each(function(key,element){
	
					if ($(element).attr('data-compare-value')=="NaN") arr_colums[i]['null_count']++;
				});
			}
			arr_colums.sort(function(a,b){return a['null_count']-b['null_count']});
			for (var i=1;i<arr_colums.length;i++)
			{
				$(arr_colums[i]['data']+" p").each(function(key,element){
					if (key!=0) {
						
						compareMap[$(element).attr('data-row-index')][i]['value']= isNaN($(element).attr('data-compare-value')) ? 0 : $(element).attr('data-compare-value')
						compareMap[$(element).attr('data-row-index')][i]['index'] = $(element).attr('data-row-index')
					}
				});
			}
			
			var ok = true;
			for (var i=0;i<arr_colums.length;i++)
			{ 
				if (ok){
					code += '<div style="width:150px;cursor:default;"  class="ui-state-default sortable-state-disabled draggable-column"  id="compare-column-'+i+'" data-column-index="'+i+'" >'+arr_colums[i]['data']+'</div>';
					ok=false;
				}else{
					code += '<div class="ui-state-default draggable-column" id="compare-column-'+i+'" data-column-index="'+i+'" >'+arr_colums[i]['data']+'</div>';
					
				}
			}
			$("#compare-items div").css('width',(arr_colums.length*180)+'px');
			
			$("#compare-items div").html('<div id="sortable" class="ui-sortable">'+code+'</div>');
			
			//generate the multidimensional array
			
			
			
			$("#sortable").sortable({
				items: "div:not(.sortable-state-disabled)",
				revert: true,
				update: function(event, ui) {
					// grabs the new positions now that we've finished sorting
					var new_position = $(this).sortable('toArray');
					
					compareMap.sort(function(a,b){return b[$("#"+new_position[0]).attr('data-column-index')]["value"]-a[$("#"+new_position[0]).attr('data-column-index')]["value"]});
					var calculateTop;
					for (var i=0;i<compareMap.length;i++)
					{
						
						calculatedTop = ((i-compareMap[i][$("#"+new_position[0]).attr('data-column-index')]['index'])*45)+"px";
						
						$(".compare-row-"+compareMap[i][$("#"+new_position[0]).attr('data-column-index')]['index']).animate({top: calculatedTop},function(){});						
					}
					
					//$(".compare-row-0").animate({top: '+=55'},function(){});
				}
			});
			
		}
		
	}
	
	this.similarProducts = function (data) {
	    $(".similar-products").html('');
		obj = JSON.parse(data);
		$.each(obj, function(key, val) {
			
			var code  = '<p><a href="#" onclick="compare.set(\''+val.title+'\');return false;"><i class="icon-plus-sign"></i></a>';
				code += '<img src="'+s3_base_link+'.s3.amazonaws.com/p_'+val.public_id+'_small.jpg" style="height: 25px;">';
				code +='<a href="'+site_root+'/product/'+val.seo_title+'" class="btn btn-link " style="font-weight:bold;color:#555;width:70%;white-space: nowrap;height:19px;overflow:hidden;text-overflow: ellipsis;text-align: left;">'+val.title+'</a></li></p>';
				
			$(".similar-products").append(code);
		})
	}
	
	
	this.showDesc = function (value) {
		$(value).find(".overlay").show();
		$(value).mouseleave(function(){
			$(this).find(".overlay").hide();
		});
	}
	
	this.compare_list = function (data) {
		if (data!=''){
			$("#compare-list div").html('');
			obj = JSON.parse(data);
			var ok = true;
			$.each(obj, function(key, val) {
				if (ok){
					similar_base_product = val.product_id;
					
					ok=false;
				}
				base_compare_product = val.product_id;
				var code = '<li style="line-height: 30px;"><a href="#" onclick="compare.remove(\''+key+'\');return false;"><i class="icon-remove"></i></a>';
					
					code +='<a href="'+site_root+'/product/'+val.seo_title+'" style="width:265px;float:right;height:19px;font-weight:bold;color:#555;overflow:hidden;text-align: left;" class="btn btn-link ">'+key+'</a></li>';
					
				$("#compare-list div").append(code);
			});
		}
	}
	
	
	this.showDesc = function (value) {
		$(value).find(".overlay").show();
		$(value).mouseleave(function(){
			$(this).find(".overlay").hide();
		});
	}
	this.advancedSearchItems = function () {
		
		$.post(site_root+"/backend/ajax.get/advanced_search.php?categories=true",{query:$('#advanced-search').val(),'categories[]':categoryList},function(data){
			
			$("#main").html("");
			
			var code = "<div class='row'><div class='span12'>";
				code += "<ul class='breadcrumb'>";
				code += "<li>";
				code += "<a href='#' onclick='render.HighestRated();'>Highest Rated</a>";
				code += "<span class='divider'>|</span>";
				code += "</li>";
				code += "<li>";
				code += "<a href='#' onclick='render.MostViewed();'>Most Viewed</a>";
				code += "<span class='divider'>|</span>";
				code += "</li>";
				code += "<li>";
				code += "<a href='#' onclick='render.RecentlyAdded();'>Recently Added</a>";
				code += "</li>";
				code += "</ul>";
				code += "<h2>Searched items</h2><hr  style='margin-top: -5px'><ul class='thumbnails'>";
			 obj = JSON.parse(data);
			 
				$.each(obj, function(key, val) {
					if (val.dislikes==null) val.dislikes=0;
					if (val.likes==null) val.likes=0;
					//alert(val.image);
					code += "<li class='span3' style='list-style: none;margin-bottom: 10px;'>";
					code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='"+site_root+"/product/"+val.seo_title+"'\" onmouseover='render.showDesc(this);' >";
					code += "<a href='#' class='thumb'>";
					code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
					code += "</div>";
					code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='"+s3_base_link+".s3.amazonaws.com/p_"+val.image.full_image_url+"_normal.jpg' ></label>";
					code += "</a>";
					code += "<div class='caption' style=''>";
					code += "<h3>"+val.title+"</h3>";
					code += "<p>";
					code += "<div class='btn-group'>";
					code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
					code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
					code += "</div>";
					code += "<a class='btn btn-small pull-right' href='"+site_root+"/product/"+val.seo_title+"'>View Product</a>";
					code += "</p>";
					code += "</div>";
					code += "</div>";
					code += "</li>";
				});
				
				if (data=="[]"){code += "<h2>Sorry, No matching results found for \""+query+"\"</h2>";}
				code += "</div></div>";
				$("#main").append(code);
			
		});
	}
	
	this.latestFeedbackAddForm = function () {
		var code = '';
			code +='<div style="margin-top:5px;">';
			var d = new Date();
			var n = d.getTime();
			code +='<form class="form-inline" style="margin-bottom:5px;">';
			code +='<input type="text" id="tweet-find-product" style="width:96%;margin-bottom: 5px;" placeholder="Choose an existing product to add your opinion">'
			code +='<img src="'+site_root+'/images/general-delete-icon.png" id="tweet-find-product-reset" onclick="render.resetProductTweet('+n+')" style="display:none;margin-top:-4px;cursor:pointer;">'
			code +='<div id="add-tweet-form"><div class="btn-group" data-toggle="buttons-radio">';
			code +='<button type="button"  onclick="feedback.addType('+n+',0);return false;" style ="height: 30px;" class="btn thumbsUp"><i class="icon icon-thumbs-up"></i></button>';
			code +='<button type="button"  onclick="feedback.addType('+n+',1);return false;" style ="height: 30px;"class="btn thumbsDown"><i class="icon icon-thumbs-down"></i></button>';
			code +='<input type="hidden" id="add-feedback-type-'+n+'" value="">';
			code +='</div>';
			code +='<input type="text" class="input-medium" placeholder="Feature" id="add-feedback-category-'+n+'" style="margin-left:3px;height: auto;">';
			code +='<input type="text" class="input-xlarge" style="width: 41%;margin-left:3px;height: auto;" id="add-feedback-comment-'+n+'" placeholder="Opinion" >';
			code +='<a data-toggle="modal" href="#" class="btn btn-primary" onclick="feedback.saveTweet('+n+',1);return false;" style="margin-left:3px;"><i class="icon icon-white icon-plus-sign" ></i> Add Opinion</a>';
			code +='</div></div>';
			$('#latest-feedback-add-form').html(code);
			$("#add-feedback-category-"+n).autocomplete({
				source: function(request, response) {
							
							$.ajax({
								type: "GET",
								url: site_root+"/backend/ajax.get/search_categories.php",
								data: {query: request.term},
								dataType: "json",
								contentType: "application/json",
								success: function(data) {
									
									response($.map(data, function(item) {
										return {
											label: item,
											value: item,
										}
									}));
								}
							});},
				position: { of: $("#add-feedback-category-"+n) },
				select: function(event, ui) { },
			});
			$('#tweet-find-product').autocomplete({
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
											product_id: item.product_id,
											value: item.title,
											seo_title: item.seo_title,
											type: item.type,
										}
									}));
								}
							});},
				position: { of: $('#tweet-find-product') },
				open: function(event, ui) {
				
				$(this).autocomplete("widget").css({
					"width": "auto"
				})},
				select: function(event, ui) { 
					product_id = ui.item.product_id;
					$('#tweet-find-product').attr('readonly','readonly');
					$('#tweet-find-product').css('width','91.5%');
					$('#tweet-find-product-reset').show();
					$("#add-tweet-form").show();
				} 
			});
	}
	this.resetProductTweet = function (n) {
		$('#tweet-find-product-reset').hide();
		$('#tweet-find-product').css('width','96%');
		$('#tweet-find-product').removeAttr('readonly');
		$('#tweet-find-product').val('');
		$("#add-feedback-category-"+n).val('');
		$("#add-feedback-comment-"+n).val('');
		$("#opinion-success").hide();
		//$("#add-tweet-form").hide();
	}
	this.latestFeedback = function (query) {
		$.post(site_root+"/backend/ajax.get/get_latest_feedback.php",{},function(data){
			var code='';
			var obj = JSON.parse(data);
			var count = obj.length;
			$.each(obj, function(key, val) {
				code += '<div style="margin:2px;line-height: 20px;"><span style="margin-right:5px;width:27%;overflow:hidden;text-overflow: ellipsis;"><a href="'+site_root+'/product/'+val.product_data.seo_title+'">'+val.product_data.title+'</a><b>,</b> '+val.category+'<b>,</b> '+val.comment+'</span></div>';
				if (key!=count-1) code += '<hr style="margin-top:5px;margin-bottom:5px;">';
			});
			$('#latest-feedback').html(code);
		});
	};
	
	this.advancedSearchMenu = function (query) {
		
		$.post(site_root+"/backend/ajax.get/advanced_search.php",{query:query},function(data){
			console.log(data);
			categoryList = [];
			$("#draggable-text").show();
			$("#advance-search-button").hide();
			$(".dropped-category").remove();
			obj = JSON.parse(data);
			$("#category-for-search").html('');
			
			$.each(obj, function(key, val) {
					
					var  code ='';
					code  += '<span class="btn btn-info" id="draggable-category-'+key+'" style="margin:3px;" id="selectable-category" data-key="'+key+'" data-value="'+val+'">'+val+'</span>';
					$("#category-for-search").append(code);
					$( '#draggable-category-'+key ).draggable({ 
        revert:  function(dropped) {
           var dropped = dropped && dropped[0].id == "droppable";
           if(!dropped) 
           return !dropped;
        },
		containment: $("#draggable-container")		
    });
			});	
			$("#dragg-to-area").show();
			$( "#dragg-to-area" ).droppable({
			  drop: function( event, ui ) {
				categoryList.push(ui.draggable.text());
				$("#dragg-to-area").append('<span class="btn btn-info dropped-category" id="dropped-'+ui.draggable.attr('data-key')+'"  style="margin:3px;">'+ui.draggable.text()+'<span onclick="removeSearchCategory('+ui.draggable.attr('data-key')+',\''+ui.draggable.attr('data-value')+'\');" style="font-weight:bold;float: right;margin-left: 5px;color: rgb(253, 174, 55);">x</span></span>');
				ui.draggable.remove();
				$("#draggable-text").hide();
				$("#advance-search-button").show();
				$( this )
				  .addClass( "ui-state-highlight" )
				  .find( "p" )
					.html( "Dropped!" );
				
			  }
			});
		});
		
	};
	
	this.search = function (query) {
		$.post(site_root+"/backend/ajax.get/search.php",{query:query},function(data){
		
			$("#main").html("");
			
			var code = "<div class='row'><div class='span12'>";
				code += "<ul class='breadcrumb'>";
				code += "<li>";
				code += "<a href='#' onclick='render.HighestRated();'>Highest Rated</a>";
				code += "<span class='divider'>|</span>";
				code += "</li>";
				code += "<li>";
				code += "<a href='#' onclick='render.MostViewed();'>Most Viewed</a>";
				code += "<span class='divider'>|</span>";
				code += "</li>";
				code += "<li>";
				code += "<a href='#' onclick='render.RecentlyAdded();'>Recently Added</a>";
				code += "</li>";
				code += "</ul>";
				code += "<h2>Searched items</h2><hr  style='margin-top: -5px'><ul class='thumbnails'>";
			 obj = JSON.parse(data);
			 
				$.each(obj, function(key, val) {
					console.log(val.seo_title);
					if (val.dislikes==null) val.dislikes=0;
					if (val.likes==null) val.likes=0;
					//alert(val.image);
					code += "<li class='span3' style='list-style: none;margin-bottom: 10px;'>";
					code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='"+site_root+"/product/"+val.seo_title+"'\" onmouseover='render.showDesc(this);' >";
					code += "<a href='#' class='thumb'>";
					code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
					code += "</div>";
					code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='"+s3_base_link+".s3.amazonaws.com/p_"+val.image.full_image_url+"_normal.jpg' ></label>";
					code += "</a>";
					code += "<div class='caption' style=''>";
					code += "<h3>"+val.title+"</h3>";
					code += "<p>";
					code += "<div class='btn-group'>";
					code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
					code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
					code += "</div>";
					code += "<a class='btn btn-small pull-right' href='"+site_root+"/product/"+val.seo_title+"'>View Product</a>";
					code += "</p>";
					code += "</div>";
					code += "</div>";
					code += "</li>";
				});
				
				if (data=="[]"){code += "<h2>Sorry, No matching results found for \""+query+"\"</h2>";}
				code += "</div></div>";
				$("#main").append(code);
			});
	};
	
	
	
	this.productsAdded = function (member_id,limit) {
	
		var code = "";
		$.post(site_root+"/backend/ajax.get/products_added.php",{member_id:member_id,limit:limit}, function(data) {
		
		obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='"+site_root+"/product/"+val.seo_title+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='"+s3_base_link+".s3.amazonaws.com/p_"+val.image.full_image_url+"_normal.jpg' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3 id='product-title'>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='"+site_root+"/product/"+val.seo_title+"'>View Product</a>";
                code += "</p>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				$("#products-added").append(code);
			});
			
		
		});
	}
	
	this.HighestRated = function(value){
		
		if (typeof value !== 'undefined') highestRatedLimit=value;
		$.post(site_root+"/backend/ajax.get/get_highest_rated.php",{start:highestRatedLimit,limit:16},function(data) {
		
		if (highestRatedLimit==0) $("#main").html('');
		
		if (highestRatedLimit==0){
			var code  = "<div class='row'><div class='span12'>";
				code += "<ul class='breadcrumb'>";
				code += "<li>";
				code += "<a href='#' onclick='render.HighestRated(0);'>Highest Rated</a>";
				code += "<span class='divider'>|</span>";
				code += "</li>";
				code += "<li>";
				code += "<a href='#' onclick='render.MostViewed(0);'>Most Viewed</a>";
				code += "<span class='divider'>|</span>";
				code += "</li>";
				code += "<li>";
				code += "<a href='#' onclick='render.RecentlyAdded(0);'>Recently Added</a>";
				code += "</li>";
				code += "</ul>";
				code += "<h2>Highest Rated </h2><hr  style='margin-top: -5px'><ul class='thumbnails'>";
		}else{
			var code = "<div class='row'><div class='span12'><ul class='thumbnails'>"; 
		}
		var obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				
				code += "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='"+site_root+"/product/"+val.seo_title+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='"+s3_base_link+".s3.amazonaws.com/p_"+val.image.full_image_url+"_normal.jpg' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3 id='product-title'>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='"+site_root+"/product/"+val.seo_title+"'>View Product</a>";
                code += "</p>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				
			});
			
			if (highestRatedLimit==0){
				code += "</ul><div style='text-align: center;' id='infinite-scroll'><a href='#' onclick='render.HighestRated();return false;' class='btn btn-info ttip' rel='tooltip' data-original-title='Infinite Scroll'>Show More</a></div></div></div>";
				$("#main").append(code);
			}else{
				code += "</ul></div></div>";
				if (data!="[]") $("#infinite-scroll").prepend(code);
			}
			highestRatedLimit+=16;
		});
	}
	
	this.MostViewed = function(value){
		if (typeof value !== 'undefined') mostViewedLimit=value;
		$.post(site_root+"/backend/ajax.get/get_most_viewed.php",{start:mostViewedLimit,limit:16},function(data) {
		if (mostViewedLimit==0) $("#main").html('');
		
		
		if (mostViewedLimit==0){
			var code  = "<div class='row'><div class='span12'>";
				code += "<ul class='breadcrumb'>";
				code += "<li>";
				code += "<a href='#' onclick='render.HighestRated(0);'>Highest Rated</a>";
				code += "<span class='divider'>|</span>";
				code += "</li>";
				code += "<li>";
				code += "<a href='#' onclick='render.MostViewed(0);'>Most Viewed</a>";
				code += "<span class='divider'>|</span>";
				code += "</li>";
				code += "<li>";
				code += "<a href='#' onclick='render.RecentlyAdded(0);'>Recently Added</a>";
				code += "</li>";
				code += "</ul>";
				code += "<h2>Most Viewed </h2><hr  style='margin-top: -5px'><ul class='thumbnails'>";
		}else{
			var code = "<div class='row'><div class='span12'><ul class='thumbnails'>"; 
		}
		
		var obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				
				code += "<li class='span3' style='margin:0 5px 10px 5px;'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='"+site_root+"/product/"+val.seo_title+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='"+s3_base_link+".s3.amazonaws.com/p_"+val.image.full_image_url+"_normal.jpg' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3 id='product-title'>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='"+site_root+"/product/"+val.seo_title+"'>View Product</a>";
                code += "</p>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				
			});
			
			if (mostViewedLimit==0){
				code += "</ul><div style='text-align: center;' id='infinite-scroll'><a href='#' onclick='render.MostViewed();return false;' class='btn btn-info ttip' rel='tooltip' data-original-title='Infinite Scroll'>Show More</a></div></div></div>";
				$("#main").append(code);
			}else{
				code += "</ul></div></div>";
				if (data!="[]") $("#infinite-scroll").prepend(code);
			}
			mostViewedLimit+=16;
		});
	}
	
	this.RecentlyAdded = function(value){
		if (typeof value !== 'undefined') recentlyAddedLimit=value;
		$.post(site_root+"/backend/ajax.get/get_recently_added.php",{start:recentlyAddedLimit,limit:16},function(data) {
		
		if (recentlyAddedLimit==0) $("#main").html("");
		
		if (recentlyAddedLimit==0){
			var code  = "<div class='row'><div class='span12'>";
				code += "<ul class='breadcrumb'>";
				code += "<li>";
				code += "<a href='#' onclick='render.HighestRated(0);'>Highest Rated</a>";
				code += "<span class='divider'>|</span>";
				code += "</li>";
				code += "<li>";
				code += "<a href='#' onclick='render.MostViewed(0);'>Most Viewed</a>";
				code += "<span class='divider'>|</span>";
				code += "</li>";
				code += "<li>";
				code += "<a href='#' onclick='render.RecentlyAdded(0);'>Recently Added</a>";
				code += "</li>";
				code += "</ul>";
				code += "<h2>Recently Added</h2><hr  style='margin-top: -5px'><ul class='thumbnails'>";
		}else{
			var code = "<div class='row'><div class='span12'><ul class='thumbnails'>"; 
		}
		
		
		var obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				
				code += "<li class='span3' style='margin:0 5px 10px 5px;'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='"+site_root+"/product/"+val.seo_title+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='"+s3_base_link+".s3.amazonaws.com/p_"+val.image.full_image_url+"_normal.jpg' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3 id='product-title'>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='"+site_root+"/product/"+val.seo_title+"'>View Product</a>";
                code += "</p>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				
			});
			
			
			if (recentlyAddedLimit==0){
				code += "</ul><div style='text-align: center;' id='infinite-scroll'><a href='#' onclick='render.RecentlyAdded();return false;' class='btn btn-info ttip' rel='tooltip' data-original-title='Infinite Scroll'>Show More</a></div></div></div>";
				$("#main").append(code);
			}else{
				code += "</ul></div></div>";
				
				if (data!="[]") $("#infinite-scroll").prepend(code);
			}
			recentlyAddedLimit+=16;
		});
	}
	
	this.homePage = function (limit) {
		var code;
		$.post(site_root+"/backend/ajax.get/get_highest_rated.php",{start:0,limit:limit},function(data) {
		
		var obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				code = "";
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='"+site_root+"/product/"+val.seo_title+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='"+s3_base_link+".s3.amazonaws.com/p_"+val.image.full_image_url+"_normal.jpg' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<hr style='margin-top: 10px;margin-bottom: 15px;'><p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-right:1px solid grey;'><strong>"+val.likes+"</strong><i style='margin-left:3px;color:#41bb19;font-size: 13px;' class='icon icon-thumbs-up'></i></button>";
                code += "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-left:1px solid grey;'><strong>"+val.dislikes+"</strong><i style='margin-left:3px;color:#f50f43;font-size: 13px;' class='icon icon-thumbs-down'></i></button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' style='padding-left:6px;padding-right:6px' href='"+site_root+"/product/"+val.seo_title+"'>View Product</a>";
                code += "</p><hr style='margin-top: 15px;margin-bottom: 15px;'>";
				 code += "<h3 id='product-title'>"+val.title+"</h3>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				$("#highest-rated").append(code);
			});
			
		
		});
		
		
		$.post(site_root+"/backend/ajax.get/get_most_viewed.php",{start:0,limit:limit},function(data) {
		
		var obj = JSON.parse(data);
			
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				code = "";
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='"+site_root+"/product/"+val.seo_title+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='"+s3_base_link+".s3.amazonaws.com/p_"+val.image.full_image_url+"_normal.jpg' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<hr style='margin-top: 10px;margin-bottom: 15px;'><p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-right:1px solid grey;'><strong>"+val.likes+"</strong><i style='margin-left:3px;color:#41bb19;font-size: 13px;' class='icon icon-thumbs-up'></i></button>";
                code += "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-left:1px solid grey;'><strong>"+val.dislikes+"</strong><i style='margin-left:3px;color:#f50f43;font-size: 13px;' class='icon icon-thumbs-down'></i></button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' style='padding-left:6px;padding-right:6px' href='"+site_root+"/product/"+val.seo_title+"'>View Product</a>";
                code += "</p><hr style='margin-top: 15px;margin-bottom: 15px;'>";
				code += "<h3 id='product-title'>"+val.title+"</h3>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				$("#most-viewed").append(code);
			});
			
			
		
		});
		
		
		$.post(site_root+"/backend/ajax.get/get_recently_added.php",{start:0,limit:limit},function(data) {
		
		var obj = JSON.parse(data);
			
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				code = "";
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='"+site_root+"/product/"+val.seo_title+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='"+s3_base_link+".s3.amazonaws.com/p_"+val.image.full_image_url+"_normal.jpg' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<hr style='margin-top: 10px;margin-bottom: 15px;'><p>";
                code += "<div class='btn-group'>";
               code += "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-right:1px solid grey;'><strong>"+val.likes+"</strong><i style='margin-left:3px;color:#41bb19;font-size: 13px;' class='icon icon-thumbs-up'></i></button>";
                code += "<button class='btn btn-small' style='background-color:white;color:black;font-size:13px;border-left:1px solid grey;'><strong>"+val.dislikes+"</strong><i style='margin-left:3px;color:#f50f43;font-size: 13px;' class='icon icon-thumbs-down'></i></button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' style='padding-left:6px;padding-right:6px' href='"+site_root+"/product/"+val.seo_title+"'>View Product</a>";
                code += "</p><hr style='margin-top: 15px;margin-bottom: 15px;'>";
				code += "<h3 id='product-title'>"+val.title+"</h3>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				$("#recently-added").append(code);
			});
			
			
		
		});
		
	};
	
	this.messageInbox = function (data,container) {
		var code = "";
		obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				code += '<div class="alert alert-warning" style="margin-bottom:5px;background-color:transparent;color:#555;"><strong><a href="member.php?id='+(val.from_member.member_id)+'">'+val.from_member.login+'</a> <i class="icon-chevron-right"></i> '+val.subject+' <i class="icon-chevron-right"></i> '+val.body+'</strong></div>';
			});
		$(container).html(code);
	};
	
	this.messageSent = function (data,container) {
		var code = "";
		obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				code += '<div class="alert alert-warning" style="margin-bottom:5px;background-color:transparent;color:#555;"><strong><a href="member.php?id='+(val.to_member.member_id)+'">'+val.to_member.login+'</a> <i class="icon-chevron-right"></i> '+val.subject+' <i class="icon-chevron-right"></i> '+val.body+'</strong></div>';
			});
		$(container).html(code);
	};
	
	this.refreshFeedback = function (data) {
		
		var obj	 = jQuery.parseJSON(data);
		var code ='';
		$.each(obj, function(root_key, root_value) {
				var href = "";
				var action = "";
				if (member_login){ href="#changeCategoryModal"; action = "category.change_name(\'"+root_value.category+"\');";} else { href= "#signInModal";}
				if (root_value.thumbs_up==null) root_value.thumbs_up=0;
				if (root_value.thumbs_down==null) root_value.thumbs_down=0;
				code += '<div>';
				code +='<p class="lead" id="'+(root_value.category.replace(/\s/g,''))+'"><a class="btn btn-success" id="total-thumbsUp-'+root_key+'">'+root_value.thumbs_up+'</a><a class="btn btn-danger" id="total-thumbsDown-'+root_key+'" style="margin-right: 1em">'+root_value.thumbs_down+'</a>'+root_value.category+'<a href="#" onclick="CollapseEvent(this);return false;" class="btn btn-warning pull-right" data-toggle="collapse" data-target="#feedback'+root_key+'"><i class="icon icon-white icon-chevron-down"></i></a></p>';
				code +='<div id="feedback'+root_key+'" class="collapse" style="height: 0px;">';
				code +='<ul class="unstyled feedback" id="unstyled-feedback-'+root_key+'">';
				$.each(root_value.feedback, function(key, value) {
					href = "";
					action = "";
					if (member_login){action = "like.add("+value.feedback_id+","+root_key+");";} else { href= "#signInModal";}
					if (value.type=="0"){ style = 'class="text-success"'; } else { style = 'class="text-warning"'; }
					code +='<li><p '+style+' style="font-size: 1.2em"><a href="'+href+'" data-toggle="modal" ><i onclick="'+action+'" class="icon icon-chevron-up" style="opacity: 0.5"></i></a> <strong id="like-'+value.feedback_id+'">'+value.total_likes+'</strong> '+value.comment+'</p></li>';
				});
				code +='<div class="form-inline">';
				code +='<div class="btn-group" data-toggle="buttons-radio">';
				code +='<button type="button" onclick="feedback.addType('+root_key+',0);return false;" style ="height: 30px;" class="btn thumbsUp"><i class="icon icon-thumbs-up"></i></button>';
				code +='<button type="button" onclick="feedback.addType('+root_key+',1);return false;" style ="height: 30px;" class="btn thumbsDown"><i class="icon icon-thumbs-down"></i></button>';
				code +='<input type="hidden" id="add-feedback-type-'+root_key+'" value="">';
				code +='</div>';
				code +='<input type="hidden" id="add-feedback-category-'+root_key+'" value="'+root_value.category+'">';
				code +='<input type="text" class="input-xlarge" style="width: 63%;margin: 0 4px 0 4px;height: auto;" id="add-feedback-comment-'+root_key+'" placeholder="Feedback">';
				if (member_login){
					code +='<a type="submit" onclick="feedback.save('+root_key+');return false;" class="btn btn-primary"><i class="icon icon-white icon-plus-sign"></i> Add Feedback</a>';
				}else{
					code +='<a data-toggle="modal" href="#signInModal" type="submit" onclick="return false;" class="btn btn-primary"><i class="icon icon-white icon-plus-sign"></i> Add Feedback</a>';
				}
				code +='</div>';
				code +='</div>';
				code +='</div>';
				
			});
			var d = new Date();
			var n = d.getTime();
			code +='<form class="form-inline">';
            code +='<div class="btn-group" data-toggle="buttons-radio">';
            code +='<button type="button"  onclick="feedback.addType('+n+',0);return false;" style ="height: 30px;" class="btn thumbsUp"><i class="icon icon-thumbs-up"></i></button>';
            code +='<button type="button"  onclick="feedback.addType('+n+',1);return false;" style ="height: 30px;"class="btn thumbsDown"><i class="icon icon-thumbs-down"></i></button>';
			code +='<input type="hidden" id="add-feedback-type-'+n+'" value="">';
            code +='</div>';
            code +='<input type="text" class="input-medium" placeholder="Category" id="add-feedback-category-'+n+'" style="margin-left:3px;height: auto;">';
            code +='<input type="text" class="input-xlarge" style="width: 41%;margin-left:3px;height: auto;" id="add-feedback-comment-'+n+'" placeholder="Feedback" >';
			if (member_login){
				code +='<a data-toggle="modal" href="#" class="btn btn-primary" onclick="feedback.save('+n+',1);return false;" style="margin-left:3px;"><i class="icon icon-white icon-plus-sign" ></i> Add Feedback</a>';
			}else{
				code +='<a data-toggle="modal" href="#signInModal" class="btn btn-primary" onclick="return false;" style="margin-left:3px;"><i class="icon icon-white icon-plus-sign" ></i> Add Feedback</a>';
			}
            code +='</form>';
		
		$("#feedback").html(code);
		
		$("#add-feedback-category-"+n).autocomplete({
			source: function(request, response) {
						
						$.ajax({
							type: "GET",
							url: site_root+"/backend/ajax.get/search_categories.php",
							data: {query: request.term},
							dataType: "json",
							contentType: "application/json",
							success: function(data) {
								
								response($.map(data, function(item) {
									return {
										label: item,
										value: item,
									}
								}));
							}
						});},
			position: { of: $("#add-feedback-category-"+n) },
			select: function(event, ui) { },
		});
		
	};
}



function CollapseEvent(el){
	
	if ($(el).find("i").attr("class")=="icon icon-white icon-chevron-down") $(el).find("i").attr("class","icon icon-white icon-chevron-up");
	else if ($(el).find("i").attr("class")=="icon icon-white icon-chevron-up") $(el).find("i").attr("class","icon icon-white icon-chevron-down");
	
}

function removeSearchCategory(key,value){
		categoryList.remove(value);
		if (categoryList.length==0){
			$("#draggable-text").show();
			$("#advance-search-button").hide();
		}
		$("#dropped-"+key).remove();
	}
//Initiate


if (member_login){
	$('#add-feedback-btn').attr('href','#addFeedbackModal');
	$('#addProductBtn').attr('href','#addProduct');
	$('#addQuestionBtn').attr('href','#');
	
}else{
	$('#add-feedback-btn').attr('href','#signInModal');
	$("#follow-product-btn").attr('href','#signInModal');
	$('#addProductBtn').attr('href','#signInModal');
	$('#addQuestionBtn').attr('href','#signInModal');
}


Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
Array.prototype.unique = function(a){
return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
});
