var app = new function() {
	var parent = this;
	
	this.post = function () {
		if (!member_login) 
		{
			$(".feedback").hide();
			$(".login-form").show();
			$(".register-form").show();
		}
	}
	
	this.login = function () {
		$.post("../backend/ajax.get/sign_in_check.php",{login:$("#login").val(),password:$("#password").val()},function(data){
		
			if (data=="true"){
				window.location.reload();
			}
		});
	}
	this.register = function () {
		$.post("../backend/ajax.post/add_app_member.php",{email:$("#email").val()},function(data){
			window.location.reload();
		});
	}
}


