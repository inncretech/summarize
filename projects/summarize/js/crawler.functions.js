
var crawler = new function() {
	var parent = this;

	
	this.listen = function (div) {
		$(div).click(function(){
			$.post("backend/ajax.get/crawl_url.php",{url:$("#link").val()},function(data){
				
				obj = JSON.parse(data);
				
					$(".product-title").val(obj.title);
					$(".description-area").val(obj.description);
					$(".image-holder").append('<input type="hidden" id="image_data" value="'+obj.image+'" w="'+obj.width+'" h="'+obj.width+'">');
					$(".image-holder img").attr("src","images/upload/product/"+obj.image);
				
			});
		});
		
	}
	
		
}

crawler.listen("#crawl-link");










