<?php
include "../backend/session.class.php";		// Base Classes
include "../backend/global.functions.php";		// Global Functions
$session 		= new Session();
$database 		= new Database();
$facebook 		= new Fb();
$twitter 		= new Tw();



// ######################## Retrive Session Data
$member_data = $session->get();

echo "<script> var member_login = ".($session->check() ? "true" : "false")."; </script>";
echo "<script> var application_id = '".($_GET['secret'])."'; </script>";
echo "<script> var thread_id = '".($_GET['thread_id'])."'; </script>";
?>
<html>
<head>
<meta charset="utf-8">

<title>SummarizeIt Application</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<link rel="stylesheet" href="../../css/bootstrap.min.css">
<link rel="stylesheet" href="../../css/design.css">

<link rel="stylesheet" href="../../js/bootstrap/google-code-prettify/prettify.css">


</head>
<body>
<table class="post-form">
<tr>
<td>
<img src="user.png" style="margin-right:5px;margin-top:-2px;">
<input type="text" class="input-xlarge" id="comment" placeholder="Comment..." style="height:auto;margin-bottom:0px;">
</td>
<td>
<button class="btn btn-primary" onclick="app.post();">Post<?=($session->check() ? " as ".$member_data['login'] : "")?></button>
</td>
</tr>
</table>

<table class="login-form" style="display:none;">
<tr>
<td>
<input type="text" class="input-xlarge" id="login" placeholder="Username"  style="height:auto;margin-bottom:0px;">
</td>
<td>
<input type="password" class="input-xlarge" id="password"  style="height:auto;margin-bottom:0px;">
</td>
<td>
<button class="btn btn-primary" onclick="app.login();">Login</button>
</td>
</tr>
</table>
<table class="register-form" style="display:none;">
<tr>
<td>
<input type="text" class="input-xlarge" id="email" placeholder="Email..."  style="height:auto;margin-bottom:0px;">
</td>
<td>
<button class="btn btn-primary" onclick="app.register();">Register</button>
</td>
</tr>
</table>
<div id="feedback" style="margin-top:10px;">
</div>
<footer>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="js/bootstrap/google-code-prettify/prettify.js"></script>
<script type="text/javascript" src="js/bootstrap/application.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-affix.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-transition.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-alert.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-modal.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-dropdown.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-scrollspy.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-tab.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-popover.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-button.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-collapse.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-carousel.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap-typeahead.js"></script>
<script type="text/javascript" src="js/feedback.functions.js"></script>
<script type="text/javascript" src="js/add.like.functions.js"></script>
<script type="text/javascript" src="js/render.functions.js"></script>
<script type="text/javascript" src="js/get.functions.js"></script>
</footer>
</body>
</html>