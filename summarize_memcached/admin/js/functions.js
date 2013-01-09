
	function requestPassword(){
		$.post("requestPassword.php",{email: $("#email").val()},function(data){});
	}
	function login(){
		$.post("admin_login.php",{email: $("#email").val(),password: $("#password").val()},function(data){window.location.href="panel.php";});
	}
