var category = new function() {
	var parent = this;
	this.change_name = function (category) {
		$("#current-category-name").text(category);
		$("#change-category-modal-error").text('');
		$("#new-category-name").val('');
		
	}
	this.listen = function(){
		$("#change-category-btn").click(function(){
			var regex = /^[ÒA-Za-z _]*[ÒA-Za-z][ÒA-Za-z _]*$/;
			var new_category = $("#new-category-name").val().replace( /[\s\n\r]+/g, ' ' );
			var old_category = $("#current-category-name").text();
			if (regex.test(new_category)){
				$.post(site_root+"/backend/ajax.post/change_category.php",{product_id:product_id,new_category:new_category,old_category:old_category},function(data){
						$("#change-category-modal-error").text("- done");
						$("#"+(old_category.replace(/\s/g,''))).text(new_category);
						parent.change_name(new_category);
				});
			}else{
				$("#change-category-modal-error").text("- invalid caracters");
			}
		});
	}
}
category.listen();
