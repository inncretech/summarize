(function(){
    var login = new function() {
		var parent = this;
		this.trigger = function (trigger,form) {
			$(trigger).click(function(){
				$.post("backend/ajax.get/sign_in_check.php",{login:$(form+" input :eq(0)").val(),password:$(form+" input :eq(1)").val()},function(data){
					
					if (data == "true"){
						document.location.reload(true);
					}else{
						$("#sign-in-modal-error").html(" - Invalid Credentials");
					}
				});
			});
		}
		
		this.sign_out = function (trigger) {
			$.post("backend/ajax.get/sign_out.php",function(data){
					if (data == "true")	document.location.reload(true);
			});
		}
		
	}
	login.trigger("#sign-in-btn","#sign-in-form");
})();
