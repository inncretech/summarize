(function(){
    var login = new function() {
		var parent = this;
		this.trigger = function (trigger,form) {
			$(trigger).click(function(){
				$.post(site_root+"/backend/ajax.get/sign_in_check.php",{login:$(form+" #login").val(),password:$(form+" #password").val()},function(data){
					
					if (data == "true"){
						document.location.reload(true);
					}else{
						$("#sign-in-modal-error").show();
					}
				});
			});
		}
		
		this.sign_out = function (trigger) {
			$.post(site_root+"/backend/ajax.get/sign_out.php",function(data){
					if (data == "true")	document.location.reload(true);
			});
		}
		
	}
	login.trigger("#sign-in-btn","#sign-in-form");
})();
