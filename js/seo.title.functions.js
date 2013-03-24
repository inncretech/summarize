var seo = new function() {
	var parent = this;
	
	this.getMemberSeoTitle = function (member_id) {
		$.post(site_root+"/backend/ajax.get/get_member_seo_title.php",{member_id:member_id},function(data){

			return data;
		});
	}
	this.getProductSeoTitle = function (product_id) {
		$.post(site_root+"/backend/ajax.get/get_product_seo_title.php",{product_id:product_id},function(data){

			return data;
		});
	}

}

