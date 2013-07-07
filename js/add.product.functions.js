(function(){
    var product = new function() {
		var parent = this;
		
		this.description = ".description-area";
		this.mainForm = "#main-form input";
		this.image_preview = "#image-preview";
		this.title = ".product-title";
		this.cost = ".product-cost";
		this.image = "#image_data";
		this.resetBtn = "#reset-form-btn";
		this.saveBtn = "#save-form-btn";
		this.externalLink = ".product-url";
		this.cost = ".product-cost";
		this.imageHolder = "#image_data";
		this.progress = false;
		
		this.reset = function () {
			$(parent.description).val('');
			$(parent.title).val('');
			$(parent.cost).val('');
			$(product.image_preview).attr('src','images/default.png');
			$("#product-main-form .tagify-container span").each(function(){ 
				$(this).remove();
			});
			add_product_tag_area.tagify();
		}
		this.save = function () {
			var ok =true;
			var tags = new Array();
			$("#product-details .tagify-container span").each(function(){ 
				
				if ($(this).attr("id")=="tag-name"){
					var aux = $(this).clone();
					tags.push(aux.find('a').remove().end().text());
				}
			});
			var title			= $(parent.title).val();
			var description 	= $(parent.description).val();
			var full_image_url 	= $(parent.image).val();
			var width	 		= $(parent.image).attr('w');
			var height 			= $(parent.image).attr('h');
			var cost 			= $(parent.cost).val();
			var externalLink 	= $(parent.externalLink).val();
			var image_data 		= $(parent.imageHolder).val();
			
			//if (tags.length==0) ok=false; console.log(tags.length);
			if (title=='') ok=false; 
			//if (description=='') ok=false; 
			if (full_image_url=="images/default.png") ok=false; 
			if (image_data=="default.png") ok=false; 
			
			if (ok){
				console.log("Add...");
				if (!this.progress){
					this.progress = true;
					$.post(site_root+"/backend/ajax.post/add_product.php",{tags: tags,title:title,description:description,full_image_url:full_image_url,width:height,height:height,cost:cost,externalLink:externalLink},function(data){
						console.log(data);
						this.progress = false;
						window.location.href= site_root+"/product/"+data;
						
					});
				}
			}else{
				$("#product-error").html("<strong>Ups!</strong>Please fill all the forms and then press submit product.");
				$("#product-error").show();
			}			
		}
		this.listen = function () {
			$(parent.resetBtn).click(function(){ 
				parent.reset();
			});
			$(parent.saveBtn).click(function(){ 
				parent.save();	
			});
		}
		
	}
	$("#manual_product_add").click(function(){
		$("#product").hide();
		$("#addProductLoading").hide();
		$("#addProductModalBody").show();
		
	});
	product.listen();
	$("#addProduct").click(function(){$("#link").val('');});
})();
