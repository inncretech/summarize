<?php
require_once "backend/session.class.php";
require_once "backend/global.functions.php";
$session = new Session();
$member_data = $session->get();

require_once "template/header.php";
if ($session->check()){
	echo "<script>var member_login = true; </script>";
	require_once "template/logged_in/top_menu.php";
	require_once "template/logged_in/add_item_modal.php";
}else{
	Redirect("index.php");
}

	?>
	<div class='search-container'>
	
	</div>
	
    <div class="container-fluid">
      <div class="container" id="spaced">
		<div class="alert alert-danger" id="product-error" style="display:none;">
            <strong>Error!</strong>
            Please complete all forms with data.
         </div>
		<form id="product-main-form" method="post" enctype="multipart/form-data" action='backend/ajax.post/image_uploader.php?product=true' style='margin:0px;'>
			<div class="thumbnail"  id="white-big-box">
			  <label id="product-image">
				<label class="image-holder">
					<img id="image-preview" data-src="holder.js/300x200" alt="300x200"   src="images/default.png">
				</label>
				<div id='preview'></div>
				
					<button class="btn" id="upload-btn">
						<input type="file" style="opacity:0;position:relative;z-index:10;cursor:pointer;" name="photo" id="product-photo">
						<input type="hidden" name="product" value="true">
						<span class="upload-btn-text">Upload Image<span>
					</button>
				
				
			  </label>
			  <div class="caption" style="padding-bottom:0px;margin-bottom:5px;text-align:right;">
				<!--<h3>Thumbnail label</h3>-->
				<p><input class="product-title" type="text" placeholder="Title" style="margin:0px;width:820px;"></p>
				<p><textarea class="tagArea">example</textarea></p>
				<textarea placeholder="Short description" class="description-area"></textarea>
			  </div>
			
			</div>
		</form>
			<a href="#" class="btn btn-primary" style="float:left;margin-top:5px;" id="save-form-btn">Save</a>
			<a  href="#useLink" data-toggle="modal" class="btn btn-primary" style="float:left;margin:5px 0 0 5px;">Use link</a>
			<a href="#" class="btn btn-primary" style="float:left;margin:5px 0 0 5px;" id="reset-form-btn">Reset</a>
	 
    </div><!--/.fluid-container-->
<?php
if ($session->check()){
	require_once "template/logged_in/footer.php";
}else{
	require_once "template/logged_out/footer.php";
}
?>
</body>
</html>
