var extension = new function() {
	var parent = this;
	var socket;
	this.login = function () {
		$.post(site_root+"/backend/ajax.get/sign_in_check.php",{login:$("#login").val(),password:$("#password").val()},function(data){
			if (data=="true"){
				member_login = true;
				$("#login-container").hide();
				$("#product-container").show();
				windowProxy.post({'member_status': member_login});
			}else{
				$("#sign-in-error").show();
				$("#sign-in-info").hide();
			}
		});
	}
	this.connect = function (){
		
	}
}


