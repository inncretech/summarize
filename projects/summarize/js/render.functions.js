
var render = new function() {
	//this.type = "class";
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
	
	
	this.showDesc = function (value) {
		$(value).find(".overlay").show();
		$(value).mouseleave(function(){
			$(this).find(".overlay").hide();
		});
	}	
	
	
	this.homePage = function () {
		var code = "";
		$.post("backend/ajax.get/highest_rated.php", function(data) {
		
		obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				//alert(val.image);
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='height: 200px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
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
		
		
		$.post("backend/ajax.get/highest_rated.php", function(data) {
		
		obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='height: 200px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
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
		$.post("backend/ajax.get/highest_rated.php", function(data) {
		
		obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				if (val.dislikes==null) val.dislikes=0;
				if (val.likes==null) val.likes=0;
				code = "<li class='span3'>";
				code += "<div class='thumbnail'  style='background-color:white;' onmouseover='render.showDesc(this);' >";
				code += "<a href='#' class='thumb'>";
                code += "<div class='overlay' style='opacity: 0.9;height: 200px;width:210px;overflow: hidden;display:none;position: absolute;color: #555;background-color: white;'>"+val.description+"";
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
				code += '<div class="alert alert-warning" style="margin-bottom:5px"><strong><a href="member.php?id='+(val.from_member.member_id)+'">'+val.from_member.login+'</a> <i class="icon-chevron-right"></i> '+val.subject+' <i class="icon-chevron-right"></i> '+val.body+'</strong></div>';
			});
		$(container).html(code);
	};
	
	this.messageSent = function (data,container) {
		var code = "";
		obj = JSON.parse(data);
			$.each(obj, function(key, val) {
				code += '<div class="alert alert-warning" style="margin-bottom:5px"><strong><a href="member.php?id='+(val.to_member.member_id)+'">'+val.to_member.login+'</a> <i class="icon-chevron-right"></i> '+val.subject+' <i class="icon-chevron-right"></i> '+val.body+'</strong></div>';
			});
		$(container).html(code);
	};
	
	this.refreshFeedback = function (data) {
		var obj	 = jQuery.parseJSON(data);
		var code ='';
		$.each(obj, function(root_key, root_value) {
			code += "<div class='accordion-group'><div class='accordion-heading'>";
			code += "<a class='accordion-toggle' id='"+(root_value.category.replace(/\s/g,''))+"' data-toggle='collapse' data-parent='#accordion2' href='#collapse"+root_key+"'>";
			code += root_value.category;
			code += "</a>";
			var href = "";
			var action = "";
			if (member_login){ href="#changeCategoryModal"; action = "category.change_name(\'"+root_value.category+"\');";} else { href= "#signInModal";}
			code += "<a href='"+href+"' data-toggle='modal' id='changeCategoryTrigger'><i onclick=\""+action+"\" class='icon-pencil' style='float:right;margin:2px 5px 5px 5px;'></i></a>";
			code += "</div>";
			code += "<div id='collapse"+root_key+"' class='accordion-body collapse'>";	
			$.each(root_value.feedback, function(key, value) {
				var color = "#DFDFFC";
				var border_color = "#BDBDF5";
				var href = "";
				var action = "";
				if (member_login){action = "like.add(\'"+value.feedback_id+"\');";} else { href= "#signInModal";}
				if (value.type==1){ color = "#FFEDED"; border_color="#F7CCCC"; }
				code += "<div class='accordion-inner' style='background-color:"+color+";border-top:1px solid "+border_color+";'>";
				code += "<span style='padding:5px 10px 5px 0px;font-weight:bold;' id='like-"+value.feedback_id+"'>"+value.total_likes+"</span>";				
				code += "<span>"+value.comment+"</span>";	
				code += "<a href='"+href+"' data-toggle='modal'><i onclick=\""+action+"\" class='icon-chevron-up' style='float:right;margin:2px 5px 5px 5px;'></i></a>";				
				code += "</div>";		
				
			});
			code += "</div>";
			code += "</div>";
		});
		$("#accordion2").html(code);
	};
}

//Initiate
render.SecretQuestions("#secret-questions");

if (member_login){
	$('#add-feedback-trigger').attr('href','#addFeedbackModal');
	
}else{
	$('#add-feedback-trigger').attr('href','#signInModal');
	$("#follow-product-btn").attr('href','#signInModal');
}



