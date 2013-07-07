var like = new function() {
	var parent = this;
	this.add = function (feedback_id,root_key) {
		$.post(site_root+"/backend/ajax.post/add_like.php",{product_id:product_id,feedback_id:feedback_id},function(data){
			var like_count = data;
			var prev_count = $("#like-"+feedback_id).text();
			$.post(site_root+"/backend/ajax.get/get_single_feedback.php",{feedback_id:feedback_id},function(data){
				data = JSON.parse(data);
				notification.send("<strong>"+data.category+"</strong> "+data.comment,"Like");
				if (data.type=="0"){
					if ($("#like-"+feedback_id).text()!=prev_count){
						var thumbsUp = parseInt($("#total-thumbsUp-"+root_key).text());
						$("#total-thumbsUp-"+root_key).text(thumbsUp+1);
					}
				}else{		
					if ($("#like-"+feedback_id).text()!=prev_count){
						var thumbsDown = parseInt($("#total-thumbsDown-"+root_key).text());
						$("#total-thumbsDown-"+root_key).text(thumbsDown+1);
					}
				}
				
			});	
			$("#like-"+feedback_id).text(like_count);
		});
	}

}

