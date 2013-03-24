
var feedback = new function() {
	var parent = this;

	this.category = "#add-feedback-category-";
	this.comment = "#add-feedback-comment-";
	this.type = "#add-feedback-type-";
	
	
	this.addType = function (root_key,value) {
		$("#add-feedback-type-"+root_key).val(value);
	}
	this.save = function (root_key,state) {
		var ok =true;
		
		var category 		= $(parent.category+root_key).val();
		var comment 		= $(parent.comment+root_key).val();
		var type 		    = $(parent.type+root_key).val();
		
		if (category=='') ok=false;
		if (comment=='') ok=false;
		if (type=='') ok=false;
		
		if (ok){
			notification.send("<strong>"+category+"</strong> "+comment,"Feedback");
			$.post(site_root+"/backend/ajax.post/add_feedback.php",{category: category, comment:comment, type:type, product_id:product_id},function(data){
				if (typeof state !== "undefined" && state!==null){
					get.feedbackByProduct(product_id);
					like.add(data,root_key);
					$('#feedback-error-msg'+root_key).remove();
				}else{
					like.add(data,root_key);
					var href = "";
					var action = "";
					if (member_login){action = "like.add("+data+","+root_key+");";} else { href= "#signInModal";}
					if (type=="0"){ style = 'class="text-success"'; } else { style = 'class="text-warning"'; }
					var code ='<li><p '+style+' style="font-size: 1.2em"><a href="'+href+'" data-toggle="modal" ><i onclick="'+action+'" class="icon icon-chevron-up" style="opacity: 0.5"></i></a> <strong id="like-'+data+'">0</strong> '+comment+'</p></li>';
					$("#unstyled-feedback-"+root_key+" .form-inline").before(code);
					$('#feedback-error-msg'+root_key).remove();
				}
			});
		}else{
			$('#feedback-error-msg'+root_key).remove();
			$("#unstyled-feedback-"+root_key).append("<div id='feedback-error-msg"+root_key+"' style='text-align:center;margin-top:5px;'>Please chose the type of feedback (Thumbs Up / Thumbs Down)</div>");
		}			
	}
	
	this.saveTweet = function (root_key,state) {
		var ok =true;
		
		var category 		= $(parent.category+root_key).val();
		var comment 		= $(parent.comment+root_key).val();
		var type 		    = $(parent.type+root_key).val();
		
		if (category=='') ok=false;
		if (comment=='') ok=false;
		if (type=='') ok=false;
		
		if (ok){
			notification.send("<strong>"+category+"</strong> "+comment,"Feedback");
			$.post(site_root+"/backend/ajax.post/add_feedback.php",{category: category, comment:comment, type:type, product_id:product_id},function(data){
				if (typeof state !== "undefined" && state!==null){
					like.add(data,root_key);
					render.latestFeedback();
					$("#opinion-success").show();
				}else{
					like.add(data,root_key);
					render.latestFeedback();
					$("#opinion-success").show();
				}
			});
		}else{
		}			
	}
	
	
}


