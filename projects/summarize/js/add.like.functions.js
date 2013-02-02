var like = new function() {
	var parent = this;
	this.add = function (feedback_id) {
		$.post("backend/ajax.post/add_like.php",{product_id:product_id,feedback_id:feedback_id},function(data){
			$.post("backend/ajax.get/get_single_feedback.php",{feedback_id:feedback_id},function(data){
				data = JSON.parse(data);
				notification.send("<strong>"+data.category+"</strong> "+data.comment,"Like");
			});
			
			$("#like-"+feedback_id).text(data);
		});
	}

}

