(function(){
    var product = new function() {
		var parent = this;
		
		this.description = ".description-area";
		this.mainForm = "#main-form input";
		this.image_preview = "#image-preview";
		this.title = ".product-title";
		this.image = "#image_data";
		this.resetBtn = "#reset-form-btn";
		this.saveBtn = "#save-form-btn";
		
		this.reset = function () {
			$(parent.description).val('');
			$(parent.title).val('');
			$(product.image_preview).attr('src','images/default.png');
			$(".tagify-container span").each(function(){ 
				$(this).remove();
			});
			$(".tagify-container").prepend('<span>example<a href="#">x</a></span>');
		}
		this.save = function () {
			var ok =true;
			var tags = new Array();
			$(".tagify-container span").each(function(){ 
				var aux = $(this).clone();
				tags.push(aux.find('a').remove().end().text());
			});
			var title			= $(parent.title).val();
			var description 	= $(parent.description).val();
			var full_image_url 	= $(parent.image).val();
			var width	 		= $(parent.image).attr('w');
			var height 			= $(parent.image).attr('h');
			
			if (tags.length==0) ok=false;
			if (title=='') ok=false;
			if (description=='') ok=false;
			if (full_image_url=="images/default.png") ok=false;
			
			if (ok){
				$.post("backend/ajax.post/add_product.php",{tags: tags,title:title,description:description,full_image_url:full_image_url,width:height,height:height},function(data){
						window.location.href="product.php?id="+data;
				});
			}else{
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
	product.listen();
})();
