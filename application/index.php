<?php
include "../backend/session.class.php";		// Base Classes
include "../backend/global.functions.php";		// Global Functions
$session 		= new Session();
$database 		= new Database();
$facebook 		= new Fb();
$twitter 		= new Tw();

// ######################## Sign Out Check
if (isset($_GET['sign_out']))
{
	$session->refresh();
	$session->getValue("social_network_name")=="facebook" ? Redirect($facebook->logoutUrl) : Redirect($_SERVER['PHP_SELF']);
}

// ######################## Member Verifications
if (!$session->check()){
	$sn_id = $session->getValue("social_network_id");
	if (isset($sn_id)){
		$member_data = $database->member->checkSocialNetwork($sn_id);
		if ($member_data!=null){
			$member_image_id		= $database->member_image->get($member_data['member_id']);
			$member_data['image'] 	=  $database->image_table->get($member_image_id);
			$session->sign_in($member_data);
			Redirect($_SERVER['PHP_SELF']);
		}
	}
}

// ######################## Retrive Session Data
$member_data = $session->get();

echo "<script> var member_login 	= ".($session->check() ? "true" : "false")."; </script>";
echo "<script> var application_id 	= '".($_GET['app_id'])."'; </script>";
echo "<script> var product_id 		= '".($_GET['thread_id'])."'; </script>";
echo "<script> var site_root 		= '".SITE_ROOT."'; </script>";
?>
<html>
<head>
<script src="http://www.summarizit.com/application/js/porthole.js"></script>
<meta charset="utf-8">

<title>SummarizeIt Application</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<link rel="stylesheet" href="http://www.summarizit.com/css/bootstrap.min.css">
<link rel="stylesheet" href="http://www.summarizit.com/css/design.css">



</head>
<body class="breadcrumb" style="background: white;border:none;">



<table class="login-form" style="display:none;width:100%">
<tr>
<td style="width:280px;">
<input type="text" class="input-xlarge" id="login" placeholder="Username"  style="width:280px;height:auto;margin-bottom:0px;">
</td>
<td>
<input type="password" class="input-xlarge" id="password"  style="height:auto;width:100%;margin-bottom:0px;">
</td>
<td style="width: 20px;">
<button class="btn btn-primary" onclick="app.login();">Login</button>
</td>
</tr>
</table>
<table class="register-form" style="display:none;width:100%">
<tr>
<td style="width:280px;">
<input type="text" class="input-xlarge" id="email" placeholder="Email..."  style="width:280px;height:auto;margin-bottom:0px;">
</td>
<td>
<button class="btn btn-primary" onclick="app.register();">Register</button>
</td>
</tr>
</table>
 <?=($member_data['login']!="" ? '<h3> Post as '.$member_data['login'].'</h3>' : "");?>
<div id="feedback" style="margin-top:10px;">
</div>
<?php ($session->check() ? include "../template/logged_in/footer.php" : include "../template/logged_out/footer.php" );?>

<script type="text/javascript" src="http://www.summarizit.com/application/js/internal.app.functions.js"></script>
<script>
var timer;
var parentUrl = decodeURIComponent((window.location.href).substr((window.location.href).indexOf("#") + 1));
console.log("iFrame Parent "+document.referrer.split('/')[2]);
function onMessage(messageEvent) {  
	if (messageEvent.data["status"]=="ready") {
		timer = setInterval(function(){sendHeight();},100);
	}
}

function sendHeight(){
	windowProxy.post({'height': $(document).height()});
}
window.onload=function(){ 
	// Create a proxy window to send to and receive message from the guest iframe
	windowProxy = new Porthole.WindowProxy(parentUrl);
	windowProxy.addEventListener(onMessage);
	windowProxy.post({'status': 'ready'});
};

if (!member_login){ 
	$(".login-form").show(); 
	$(".register-form").show();
}
</script>
</body>
</html>