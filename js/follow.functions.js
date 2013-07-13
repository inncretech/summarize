var follow = new function() {
	var parent = this;

	this.checkState = function (btn) {
		$.post(site_root+"/backend/ajax.get/follow_product_state.php",{product_id:product_id},function(data){
				
				if (data == "true") $(btn).text("Unfollow Product"); else $(btn).text("Follow Product");
				parent.listen(btn);
		});
	}
	
	this.listen = function (btn) {
		$(btn).click(function(){
			$.post(site_root+"/backend/ajax.post/follow_product_toggle_state.php",{product_id:product_id},function(data){
				
				if (data == "true") $(btn).text("Follow Product"); else $(btn).text("Unfollow Product");
			});
		});
	}
	
}
if (typeof product_id != 'undefined') follow.checkState("#follow-product-btn");

function unFollow (e,pid) {
	$.post(site_root+"/backend/ajax.post/follow_product_toggle_state.php",{product_id:pid},function(data){
		$(e).parent().hide();
	});
}
