
var report = new function() {
	var parent = this;
	
	this.add = function () {
		$.post("backend/ajax.post/report_product.php",{product_id:product_id},function(data){
		
		});
		
	}
}


