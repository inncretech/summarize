(function(){
    var feedback = new function() {
		var parent = this;

		this.category = "#add-feedback-category";
		this.comment = "#add-feedback-comment";
		this.type = "#add-feedback-type";
		this.saveBtn = "#add-feedback-btn";
		
		this.save = function (product_id) {
			var ok =true;
			
			var category 		= $(parent.category).val();
			var comment 		= $(parent.comment).val();
			var type 		    = $(parent.type).val();
			
			if (category=='') ok=false;
			if (comment=='') ok=false;
			
			if (ok){
				notification.send("<strong>"+category+"</strong> "+comment,"Feedback");
				$.post("backend/ajax.post/add_feedback.php",{category: category, comment:comment, type:type, product_id:product_id},function(data){
				
					if (data=="true"){
						get.feedbackByProduct(product_id);
						$("#add-feedback-modal-error").text("- feedback added");
					}
				});
			}else{
				$("#add-feedback-modal-error").text("- please fill all data");
			}			
		}
		this.listen = function (product_id) {
			$(parent.saveBtn).click(function(){ 
				parent.save(product_id);
			});
		}
		
	}
	if (typeof product_id != 'undefined') feedback.listen(product_id);
})();
