
var crawler = new function() {
	var parent = this;
	var externalLink;
	
	this.listen = function (div) {
		$("#link").keyup(function(){
			if ($("#link").val()!=""){
				$.post(site_root+"/backend/ajax.get/check_crawl_link.php",{url:$("#link").val()},function(data){
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
			}else{
				$("#crawler-error").hide(); 
				$("#crawler-success").hide(); 
			}
		});
		function IsJsonString(str) {
					try {
						JSON.parse(str);
					} catch (e) {
						return false;
					}
					return true;
				}
		$(div).click(function(){
		
			$("#product-error").hide();
			$("#addProductModalBody").hide();
			
			$("#addProductLoading").show();
			$.post(site_root+"/backend/ajax.get/crawl_url.php",{url:$("#link").val()},function(data){
				
				if ((data!="")&&(IsJsonString(data))){
					obj = JSON.parse(data);
					
					$(".product-title").val(obj.title);
					$(".description-area").val(obj.description);
					$(".product-cost").val(obj.cost);
					$(".product-url").val(obj.url);
					$("#image_data").remove();
					if (obj.image!=null) $(".image-holder-product").append('<input type="hidden" id="image_data" value="'+obj.image+'" w="'+obj.width+'" h="'+obj.width+'">');
					if (obj.image!=null) $(".image-holder-product img").attr("src",s3_base_link+".s3.amazonaws.com/p_"+obj.image+"_normal.jpg");
				}else{
					$.post(site_root+'/backend/ajax.post/add_crawl_site.php',{url:this.externalLink},function(data){});
					$("#product-error").html("<strong>Sorry, we encountered an error while extracting product details</strong>Please add the product manually.");
					$("#product-error").show();
				}
				$("#addProductLoading").hide();
				$("#addProductModalBody").show();
				
			});
		});
		
	}
	
		
}

crawler.listen("#crawl-link");
$("#addProductBtn").click(function(){$("#crawler-error").hide();$("#crawler-success").hide(); });

$("#propose-btn").click(function(){
	$.post(site_root+'/backend/ajax.post/add_crawl_site.php',{url:$('#propose-url').val()},function(data){
		$("#propose-success").show();
	});
	
});
$("#propose-modal-btn").click(function(){$("#propose-success").hide();});








