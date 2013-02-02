
var render = new function() {
	//this.type = "class";
	
	this.discuss = function (data) {
		
		var code ='';
		obj = JSON.parse(data);
		$.each(obj, function(key, val) {
			code +='<li>';
			code +='<a href="#" onclick="return false;" class="btn btn-link" style="padding-left: 0" data-toggle="collapse" data-target="#faq'+key+'">'+val.question.question_text+'</a>';
			code +='<div class="collapse" id="faq'+key+'" >';
			code +='<div id="answerAddForm'+val.question.question_id+'" style="width:90%;">';
			$.each(val.answers, function(index, answer) {
				code +='<div><span style="position: relative;padding-right: 10px;top: 10px;"><i style="cursor:pointer;" class="icon-chevron-up" onclick="discuss.rateAnswer(\''+answer.answers_id+'\',0);"></i><br><i style="cursor:pointer;" class="icon-chevron-down" onclick="discuss.rateAnswer(\''+answer.answers_id+'\',1);"></i></span><a href="member.php?id='+answer.member_id+'">'+answer.login+'</a>: <span id="answerText'+answer.answers_id+'">'+answer.answer_text+'</span><span id="ansrating'+answer.answers_id+'" style="float:right;">'+answer.total_likes+'/'+answer.total_unlikes+'</span></div>';
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
	
	
	this.SecretQuestions = function (object) {
		var code = "<select class='select-xlarge' name='ref_secret_question1_id' id='ref_secret_question1_id'>";
		$.post("backend/ajax.get/register_details.php", function(data) {
		obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				code += '<option name="'+val.id+'" id="'+val.id+'">'+val.secret_question+'</option>';
			});
		code += "</select>";
		$(object).html(code);
		});
	};
	
	
	this.compare_table = function (data) {
		$("#compare-table").html('');
		
		var code  = '<table class="table">';
		obj = JSON.parse(data);
		var category = new Array();
		$.each(obj, function(key, val) {
			$.each(val.category, function(name, thumbs) {
				category.push(name);
			});
		});
		category = category.unique();
		code +='<tr><th>Product</th>';
		$.each(category, function(index, value) {
			code +='<th>'+value+'</th>';
		});
		$.each(obj, function(title, info) {
			code += '<tr><td>'+title+'</td>';
			$.each(category, function(index, value) {
				var thumbs_up 	= "N";
				var thumbs_down = "A";
				$.each(info.category, function(name, val) {
					if ( name == value){thumbs_up = val.thumbs_up;thumbs_down = val.thumbs_down;}
				});
				code += '<td>'+thumbs_up+"/"+thumbs_down+'</td>';
			});	
			code += '</tr>';
		});
		code +='</tr>';
		
		
		code +='</table>';
		
		$("#compare-table").html(code);
	}
	
	this.compare_list = function (data) {
		$("#compare-list").html('<li style="margin-top: 10px"><a href="#compareProducts" role="button" class="btn btn-block" data-toggle="modal" onclick="compare.refresh_table();" style="background-color: whitesmoke;">Compare Listed Products</a></li>');
		obj = JSON.parse(data);
		$.each(obj, function(key, val) {
			var code = '<li><a href="#" onclick="compare.remove(\''+key+'\');return false;"><i class="icon-remove"></i></a>';
				if (key.length) key = key.substring(0, 19)+"...";
				code +='<a href="product.php?id='+val.product_id+'" class="btn btn-link ">'+key+'</a></li>';
				
			$("#compare-list").prepend(code);
		});
	}
	
	
	this.showDesc = function (value) {
		$(value).find(".overlay").show();
		$(value).mouseleave(function(){
			$(this).find(".overlay").hide();
		});
	}
	
	
	this.search = function (query) {
		$.post("backend/ajax.get/search.php",{query:query},function(data){
			$("#main").html('');
			
			var code = "<div class='row' style='width: 720px;margin-left: auto;margin-right: auto;'><div class='span9' style='width: 720px;' >";
			 obj = JSON.parse(data);
			 
				$.each(obj, function(key, val) {
					if (val.dislikes==null) val.dislikes=0;
					if (val.likes==null) val.likes=0;
					//alert(val.image);
					code += "<li class='span3' style='list-style: none;margin-bottom: 10px;'>";
					code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='product.php?id="+val.product_id+"'\" onmouseover='render.showDesc(this);' >";
					code += "<a href='#' class='thumb'>";
					code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
					code += "</div>";
					code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='images/upload/product/"+val.image.full_image_url+"' ></label>";
					code += "</a>";
					code += "<div class='caption' style=''>";
					code += "<h3>"+val.title+"</h3>";
					code += "<p>";
					code += "<div class='btn-group'>";
					code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
					code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
					code += "</div>";
					code += "<a class='btn btn-small pull-right' href='product.php?id="+val.product_id+"'>View Product</a>";
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
		$.post("backend/ajax.get/products_added.php",{member_id:member_id,limit:limit}, function(data) {
		
		obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='product.php?id="+val.product_id+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='images/upload/product/"+val.image.full_image_url+"' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='product.php?id="+val.product_id+"'>View Product</a>";
                code += "</p>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				$("#products-added").append(code);
			});
			
		
		});
	}
	
	this.HighestRated = function(){
		$.post("backend/ajax.get/get_highest_rated.php",{start:0,limit:20},function(data) {
		$("#main").html('');
		
		var code = "<div class='row' style='width: 745px;margin-left: auto;margin-right: auto;'><div class='span9' style='width: 745px;' > <h2>Highest Rated </h2><hr  style='margin-top: -5px'><ul>";
		var obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				
				code += "<li class='span3' style='margin:0 5px 10px 5px;'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='product.php?id="+val.product_id+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='images/upload/product/"+val.image.full_image_url+"' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='product.php?id="+val.product_id+"'>View Product</a>";
                code += "</p>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				
			});
			code += "</ul></div></div>";
			$("#main").html(code);
		});
	}
	
	this.MostViewed = function(){
		$.post("backend/ajax.get/get_most_viewed.php",{start:0,limit:20},function(data) {
		$("#main").html('');
		
		var code = "<div class='row' style='width: 745px;margin-left: auto;margin-right: auto;'><div class='span9' style='width: 745px;' > <h2>Most Viewed</h2><hr  style='margin-top: -5px'><ul>";
		var obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				
				code += "<li class='span3' style='margin:0 5px 10px 5px;'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='product.php?id="+val.product_id+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='images/upload/product/"+val.image.full_image_url+"' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='product.php?id="+val.product_id+"'>View Product</a>";
                code += "</p>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				
			});
			code += "</ul></div></div>";
			$("#main").html(code);
		});
	}
	
	this.RecentlyAdded = function(){
		$.post("backend/ajax.get/get_recently_added.php",{start:0,limit:20},function(data) {
		$("#main").html();
		
		var code = "<div class='row' style='width: 745px;margin-left: auto;margin-right: auto;'><div class='span9' style='width: 745px;' > <h2>Recently Added</h2><hr  style='margin-top: -5px'><ul>";
		var obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				
				code += "<li class='span3' style='margin:0 5px 10px 5px;'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='product.php?id="+val.product_id+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='images/upload/product/"+val.image.full_image_url+"' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='product.php?id="+val.product_id+"'>View Product</a>";
                code += "</p>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				
			});
			code += "</ul></div></div>";
			$("#main").html(code);
		});
	}
	
	this.homePage = function () {
		var code;
		$.post("backend/ajax.get/get_highest_rated.php",{start:0,limit:3},function(data) {
		
		var obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				code = "";
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='product.php?id="+val.product_id+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='images/upload/product/"+val.image.full_image_url+"' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='product.php?id="+val.product_id+"'>View Product</a>";
                code += "</p>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				$("#highest-rated").append(code);
			});
			
		
		});
		
		
		$.post("backend/ajax.get/get_most_viewed.php",{start:0,limit:3},function(data) {
		
		var obj = JSON.parse(data);
			
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				code = "";
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='product.php?id="+val.product_id+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='images/upload/product/"+val.image.full_image_url+"' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='product.php?id="+val.product_id+"'>View Product</a>";
                code += "</p>";
                code += "</div>";
				code += "</div>";
				code += "</li>";
				$("#most-viewed").append(code);
			});
			
			
		
		});
		
		
		$.post("backend/ajax.get/get_recently_added.php",{start:0,limit:3},function(data) {
		
		var obj = JSON.parse(data);
			
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				code = "";
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onclick=\"window.location.href='product.php?id="+val.product_id+"'\" onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 215px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
                code += "</div>";
                code += "<label class='thumbnail-image-holder' ><img alt='210x140' src='images/upload/product/"+val.image.full_image_url+"' ></label>";
                code += "</a>";
                code += "<div class='caption' style=''>";
                code += "<h3>"+val.title+"</h3>";
                code += "<p>";
                code += "<div class='btn-group'>";
                code += "<button class='btn btn-small btn-success'>"+val.likes+"</button>";
                code += "<button class='btn btn-small btn-danger'>"+val.dislikes+"</button>";
                code += "</div>";
                code += "<a class='btn btn-small pull-right' href='product.php?id="+val.product_id+"'>View Product</a>";
                code += "</p>";
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
				code +='<p class="lead" id="'+(root_value.category.replace(/\s/g,''))+'"><a class="btn btn-success" id="total-thumbsUp-'+root_key+'">'+root_value.thumbs_up+'</a><a class="btn btn-danger" id="total-thumbsDown-'+root_key+'" style="margin-right: 1em">'+root_value.thumbs_down+'</a>'+root_value.category+'<a href="#" onclick="return false;" class="btn btn-warning pull-right" data-toggle="collapse" data-target="#feedback'+root_key+'"><i class="icon icon-white icon-chevron-down"></i></a></p>';
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
				code +='<button type="button" onclick="feedback.addType('+root_key+',0);return false;" class="btn "><i class="icon icon-thumbs-up"></i></button>';
				code +='<button type="button" onclick="feedback.addType('+root_key+',1);return false;" class="btn "><i class="icon icon-thumbs-down"></i></button>';
				code +='<input type="hidden" id="add-feedback-type-'+root_key+'" value="">';
				code +='</div>';
				code +='<input type="hidden" id="add-feedback-category-'+root_key+'" value="'+root_value.category+'">';
				code +='<input type="text" class="input-xlarge" style="width: 63%;margin: 0 4px 0 4px;" id="add-feedback-comment-'+root_key+'" placeholder="Feedback">';
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
            code +='<button type="button"  onclick="feedback.addType('+n+',0);return false;" class="btn "><i class="icon icon-thumbs-up"></i></button>';
            code +='<button type="button"  onclick="feedback.addType('+n+',1);return false;" class="btn "><i class="icon icon-thumbs-down"></i></button>';
			code +='<input type="hidden" id="add-feedback-type-'+n+'" value="">';
            code +='</div>';
            code +='<input type="text" class="input-medium" placeholder="Category" id="add-feedback-category-'+n+'" style="margin-left:3px;">';
            code +='<input type="text" class="input-xlarge" style="width: 41%;margin-left:3px;" id="add-feedback-comment-'+n+'" placeholder="Feedback" >';
			if (member_login){
				code +='<a data-toggle="modal" href="#" class="btn btn-primary" onclick="feedback.save('+n+',1);return false;" style="margin-left:3px;"><i class="icon icon-white icon-plus-sign" ></i> Add Feedback</a>';
			}else{
				code +='<a data-toggle="modal" href="#signInModal" class="btn btn-primary" onclick="return false;" style="margin-left:3px;"><i class="icon icon-white icon-plus-sign" ></i> Add Feedback</a>';
			}
            code +='</form>';
		
		$("#feedback").html(code);
		
		$('#add-feedback-category-'+n).typeahead({source: function (typeahead, query) {
		source_data = [];
		
			
			$.ajax({
				url: "backend/ajax.get/get_category_autocomplete.php",
				data: { 
					query: query,
					product_id: product_id
				},
				type: "POST",
				dataType: 'json',
				success: function(data, textStatus, xhr) {
					$.each(data, function (i, value) {
						
						
						source_data.push(value);
					});
					typeahead.process(source_data);
				},
				error: function(xhr, textStatus, errorThrown) {
					alert(textStatus);
				}
			});
			},
			onselect: function (obj) {
				
				
			}
			
		});
	};
}

//Initiate
render.SecretQuestions("#secret-questions");

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

Array.prototype.unique = function(a){
return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
});

