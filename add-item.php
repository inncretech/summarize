<?php
require_once "backend/session.class.php";
$session = new Session();
$data = $session->get();

require_once "template/header.php";
if ($session->check()){
	require_once "template/logged_in/top_menu.php";
}else{
	require_once "template/logged_out/top_menu.php";
	require_once "template/logged_out/sign_in_modal.php";
	require_once "template/logged_out/register_modal.php";
}
	
	
	?>
	<div class='search-container'>
	
	</div>
	
    <div class="container-fluid">
      <div class="container" id="spaced">
	  <form>
			<div class="thumbnail"  id="white-big-box">
			  <img data-src="holder.js/300x200" alt="300x200" id="product-image"  src="images/default.png">
			  <div class="caption" style="padding-bottom:0px;margin-bottom:5px;text-align:right;">
				<!--<h3>Thumbnail label</h3>-->
				<p><input type="text" placeholder="Title" style="margin:0px;width:820px;"></p>
				<p><textarea class="tagArea">example</textarea></p>
				<textarea placeholder="Short description" class="description-area"></textarea>
			  </div>
			
			</div>
			<a href="#" class="btn btn-primary" style="float:left;margin-top:5px;">Save</a>
			<a href="#" class="btn btn-primary" style="float:left;margin:5px 0 0 5px;">Use link</a>
			<a href="#" class="btn btn-primary" style="float:left;margin:5px 0 0 5px;">Reset</a>
	  </form>
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
