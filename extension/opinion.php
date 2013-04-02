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


<style>
	.tagify-container{
		margin:0px;
		padding:0px;
		width:100%;
	}
	.tagify-container > input{
		height:23px;
	}
</style>
</head>
<body style="border: 1px solid #ddd;border-radius: 5px;">

<div class="modal-body" id="login-container" >
	<div class="alert alert-success" id="sign-in-info" style="margin-bottom: 10px;">
		<strong>Hi!</strong> You can add here a quick short feedback.
	</div>
	
		<input type="text" id="login" placeholder="Eg, #product#feedback" AUTOCOMPLETE=OFF style="width:88%;">
		<button type="submit" class="btn btn-primary"  style="margin-bottom: 10px;" id="sign-in-btn">Add</button>

	</form>
</div>

</div>
<footer>


<script>

</footer>
</body>
</html>