
var crawler = new function() {
	var parent = this;
	var externalLink;
	
	this.listen = function (div) {
		$("#link").keyup(function(){
			
			$.post("backend/ajax.get/check_crawl_link.php",{url:$("#link").val()},function(data){
				
				if (data=="false"){
					$("#crawler-error").show(); 
					$("#crawler-success").hide(); 
					$("#crawl-link").attr("disabled","disabled");    
				}else {
					$("#crawler-error").hide();
					$("#crawler-success").show();
					externalLink = $("#link").val();
					$("#crawl-link").removeAttr("disabled");    
				}
			});
		});
		$(div).click(function(){
			$("#addProductModalBody").hide();
			$("#addProductLoading").show();
			$.post("backend/ajax.get/crawl_url.php",{url:$("#link").val()},function(data){
				
				if (data!=""){
					obj = JSON.parse(data);
					$(".product-title").val(obj.title);
					$(".description-area").val(obj.description);
					$("#image_data").remove();
					$(".image-holder").append('<input type="hidden" id="image_data" value="'+obj.image+'" w="'+obj.width+'" h="'+obj.width+'">');
					$(".image-holder img").attr("src","images/upload/product/"+obj.image);
				}else{
					$("#product-error").show();
				}
				$("#addProductLoading").hide();
				$("#addProductModalBody").show();
				$(".product-url").val(externalLink);
			});
		});
		
	}
	
		
}

crawler.listen("#crawl-link");










