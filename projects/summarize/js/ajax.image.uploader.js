(function(){
    var ajax_image_uploder = new function() {
		var parent = this;
		this.trigger = function (trigger,alert,form) {
			$(trigger).live('change', function(){ 
			$(alert).text('');
			$(alert).text('Please wait...');
			$(form).ajaxForm({target: '.image-holder',success: function(){$(alert).text('Upload Image');}}).submit();
			});
		}
		
	}
	ajax_image_uploder.trigger('#product-photo',".upload-btn-text","#product-main-form");
	ajax_image_uploder.trigger('#member-photo',".upload-btn-text","#member-main-form");
})();
