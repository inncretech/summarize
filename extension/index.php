<?php
include "../backend/session.class.php";		// Base Classes
include "../backend/global.functions.php";		// Global Functions
$session 		= new Session();
$database 		= new Database();

// ######################## Retrive Session Data
$member_data = $session->get();

echo "<script> var member_login = ".($session->check() ? "true" : "false")."; </script>";
echo "<script> var site_root    = '".SITE_ROOT."'; </script>";
?>
<html>
<head>
<meta charset="utf-8">
<title>SummarizeIt Extension</title>
<link rel="stylesheet" href="<?=SITE_ROOT;?>/extension/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=SITE_ROOT;?>/extension/css/design.css">
</head>
<body style="border: 2px solid grey;>
<iframe style="display:none;" id="xd_frame"></iframe>
<div class="modal-body" id="login-container" style="display:none;">
	<div class="alert alert-success" id="sign-in-info" style="margin-bottom: 10px;">
		<strong>SummarizIt</strong> Please login to add a product.
	</div>
	<div class="alert alert-danger" id="sign-in-error" style="display:none;margin-bottom: 10px;">
		<strong>Ups!</strong> Invalid Credentials.
	</div>

	
		<input type="text" id="login" placeholder="Login" AUTOCOMPLETE=OFF>
		<input type="password" id="password" placeholder="Password">
		<button type="submit" class="btn btn-primary" onclick="extension.login();return false;" style="margin-bottom: 10px;" id="sign-in-btn">Sign in</button>

	</form>
</div>
<div class="modal-body" id="product-container" style="display:none;">
<table style="width:100%">
	<tr>
		<td rowspan="2" style="width:150px">
			<img src="images/default.jpg" style="width:150px;height:150px;">
		</td>
		<td>
			<input type="text" placeholder="Title" style="width:100%;margin:0px;margin-left:5px;">
		</td>
	</tr>
	<tr>
		<td>
			<textarea style="width:100%;height:100%;margin:0px;margin-left:5px;resize:none;" placeholder="Description"></textarea>
		</td>

	</tr>

</table>
</div>
<footer>
<script type="text/javascript" src="<?=SITE_ROOT;?>/extension/js/jquery.min.js"></script>
<script type="text/javascript" src="<?=SITE_ROOT;?>/extension/js/porthole.js"></script>
<script type="text/javascript" src="<?=SITE_ROOT;?>/extension/js/extension.functions.js"></script>
<script>
if (member_login) $("#product-container").show(); else $("#login-container").show();
var parentUrl = decodeURIComponent((window.location.href).substr((window.location.href).indexOf("#") + 1));

function onMessage(messageEvent) {  
	console.log(messageEvent.data["status"]);
	if (messageEvent.data["status"]=="ready") {
		windowProxy.post({'member_status': member_login});
	}
}
window.onload=function(){ 
	// Create a proxy window to send to and receive message from the guest iframe
	windowProxy = new Porthole.WindowProxy(parentUrl);
	windowProxy.addEventListener(onMessage);
};
</script>
</footer>
</body>
</html>