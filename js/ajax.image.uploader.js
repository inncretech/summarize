(function(){
    var ajax_image_uploder = new function() {
		var parent = this;
		this.trigger = function (trigger,alert,form,target) {
			$(trigger).change(function(){ 
			$(alert).text('');
			$(alert).text('Please wait...');
			$(form).ajaxForm({target: target,success: function(data){console.log(data);$(alert).text('Upload Image');}}).submit();
			});
		}
		
	}
	ajax_image_uploder.trigger('#product-photo',".upload-btn-text","#product-main-form",".image-holder-product");
	ajax_image_uploder.trigger('#member-photo',".upload-btn-text","#member-main-form",".image-holder");
})();
