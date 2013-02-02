var get = new function() {
	var parent = this;
	this.feedbackByProduct = function (product_id) {
		$.post("backend/ajax.get/get_feedback.php",{product_id:product_id},function(data){
			//alert(data);
			render.refreshFeedback(data);
		});		
	}
}
if (typeof product_id != 'undefined') get.feedbackByProduct(product_id);