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
<link rel="stylesheet" href="<?=SITE_ROOT;?>/extension/css/tagify-style.css">

<style>
	.tagify-container{
		margin:0px;
		padding:0px;
		width:100%;
	}
	.tagify-container > input{
		height:23px;
	}
	.next-btn{
		margin-top:-23px;float:right;border:none;background-color:rgb(206, 206, 206);color: white;border-radius: 5px;
	}
	.prev-btn{
		margin-top:-23px;float:left;border:none;background-color:rgb(206, 206, 206);color: white;border-radius: 5px;
	}
	.next-btn:hover{
		background-color:rgb(214, 214, 214);
	}
	.prev-btn:hover{
		background-color:rgb(214, 214, 214);
	}
</style>
</head>
<body style="border: 1px solid #ddd;">
<iframe style="display:none;" id="xd_frame"></iframe>
<div class="modal-body" id="login-container" style="display:none;">
	<div class="alert alert-success" id="sign-in-info" style="margin-bottom: 10px;">
		<strong>Welcome!</strong> Please login to add a product.
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
<div class="alert alert-success" id="product-success" style="display:none;margin-bottom: 10px;">
	<strong>Thank you!</strong> Click <a id="product-success-url" href="" target="_blank">here</a>.
</div>
<div class="alert alert-danger" id="product-error" style="display:none;margin-bottom: 10px;">
	<strong>Ups!</strong> Please fill all forms to add a product.
</div>
<table style="width:100%">
	<tr>
		<td rowspan="3" style="width:20%" valign="top">		
			<form id="product-main-form" method="post" style='margin:0px;'>
				<div id="product-image" style="width:150px;height: 100px;overflow: hidden;">
					<label class="image-holder-product">
						<input type="hidden" id="image_data" value="default.png" w="300" h="200">
						<input type="hidden" id="public_id" value="" w="300" h="200">
						<img id="image-preview" style="max-height:100px;" data-src="holder.js/300x200" alt="300x200" src="/images/default.png">
						
					</label>
				</div>
			</form>
			<button class="next-btn" onclick="nextImage();return false;">Next</button>
			<button class="prev-btn" onclick="prevImage();return false;">Prev</button>
		</td>
		<td>
			<input class="product-title" type="text" placeholder="Title" style="margin:0px;width:100%;border:none;">
		</td>
	</tr>
	<!--
	<tr>
		<td>
		<textarea class="addProductTagArea" style="display:none;">example</textarea></p>
		</td>
	</tr>
	<tr>
		<td>
			<textarea placeholder="Short description" class="description-area"  style="height:50px;width:100%;margin:0;overflow:hidden;"></textarea>
		</td>
	</tr>
	-->
	<tr>
		<td>
			
		
			<input class="product-url" type="text" placeholder="External Link" style="margin:5px 5px 5px 0;float:left;width:100%;border:none;">
			<input class="product-cost" type="text" placeholder="Cost" style="float:left;width:75%;margin:0px;margin-right:5px;border:none;">
			<a class="btn btn-primary pull-right " style="float:left;width:16%;" id="save-form-btn" onclick="product.save();">
				<i class="icon-plus icon-white"></i> Add
			</a>
		</td>
	</tr>
</table>

</div>
<footer>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script type="text/javascript" src="<?=SITE_ROOT;?>/extension/js/jquery.tagify.js"></script>
<script type="text/javascript" src="<?=SITE_ROOT;?>/extension/js/porthole.js"></script>
<script type="text/javascript" src="<?=SITE_ROOT;?>/extension/js/extension.functions.js"></script>

<script>
if (member_login) $("#product-container").show(); else $("#login-container").show();
var parentUrl = decodeURIComponent((window.location.href).substr((window.location.href).indexOf("#") + 1));
var images = new Array();
var image_index = 0;

function nextImage(){
	if (images.length-1!=image_index) image_index++;
	$("#image-preview").attr('src',images[image_index]);
	$("#image_data").val(images[image_index]);
}
function prevImage(){
	if (image_index>0) image_index--;
	$("#image-preview").attr('src',images[image_index]);
	$("#image_data").val(images[image_index]);
}

function onMessage(messageEvent) {  
	if (messageEvent.data["status"]=="ready") {
		windowProxy.post({'member_status': member_login});
	}
	if (messageEvent.data["images"]){
		images = messageEvent.data["images"];
		$("#image-preview").attr('src',images[image_index]);
		$("#image_data").val(images[image_index]);
	}
}
window.onload=function(){ 
	// Create a proxy window to send to and receive message from the guest iframe 
	windowProxy = new Porthole.WindowProxy(parentUrl);
	windowProxy.addEventListener(onMessage);

	setInterval(function(){windowProxy.post({'height': $(document).height()});},10);
};

var product = new function() {
	var parent = this;
	
	this.description = ".description-area";
	this.image_preview = "#image-preview";
	this.title = ".product-title";
	this.cost = ".product-cost";
	this.image = "#image_data";
	this.externalLink = ".product-url";
	this.cost = ".product-cost";
	this.imageHolder = "#image_data";
	
	this.save = function () {
		$.post(site_root+"/backend/ajax.post/image_url_upload.php",{url:$('#image-preview').attr('src')},function(data){
			var ok =true;
			var tags = new Array();
			$(".tagify-container span").each(function(){ 
				
				if ($(this).attr("id")=="tag-name"){
					var aux = $(this).clone();
					tags.push(aux.find('a').remove().end().text());
				}
			});
			var title			= $(parent.title).val();
			var description 	= $(parent.description).val();
			var public_id 	    = data;
			var width	 		= $(parent.image).attr('w');
			var height 			= $(parent.image).attr('h');
			var cost 			= $(parent.cost).val();
			var externalLink 	= $(parent.externalLink).val();
			var image_data 		= $(parent.imageHolder).val();
			
			//if (tags.length==0) ok=false;
			if (title=='') ok=false;
			if (public_id=='') ok=false;
			//if (description=='') ok=false;
			if (image_data=="default.png") ok=false;
			//console.log(title+' '+public_id+' '+image_data);
			if (ok){
				$.post(site_root+"/backend/ajax.post/add_product.php",{tags: tags,title:title,description:description,full_image_url:public_id,width:height,height:height,cost:cost,externalLink:externalLink},function(data){
					$("#product-error").hide();
					$("#product-success").show();
					$("#product-success-url").attr('href',site_root+'/product/'+data);
				});
			}else{
				$("#product-error").show();
				$("#product-success").hide();
			}			
	
		});
	}
}
</script>
</footer>
</body>
</html>