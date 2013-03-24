<?php
if (isset($_POST['sign-in-btn'])){
	include "../backend/session.class.php";
	include "../backend/global.functions.php";
	$database = new Database();
	$data = $database->escape($_POST);
	$info = $database->member->check_user($data);
	 
	if ($info == false){
			
	}else{
		$session 			= new Session();
		
		$info['info'] 		= $database->member_info->get($info['member_id']);
		$member_image_id    = $database->member_image->get($info['member_id']);
		$info['image'] 		= $database->image_table->get($member_image_id);
		
		$session->sign_in($info);
		$session->setValue("next",$data["next"]);
		Redirect(SITE_ROOT.'/admin/');
	}
}
$no_visible_elements=true;
include('header.php'); 
?>

			<div class="row-fluid">
				<div class="span12 center login-header">
					<h2>Welcome to SummarizIt</h2>
				</div><!--/span-->
			</div><!--/row-->
			
			<div class="row-fluid">
				<div class="well span5 center login-box">
					<div class="alert alert-info">
						Please login with your Username and Password.
					</div>
					<form class="form-horizontal" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
						<fieldset>
							<div class="input-prepend" title="Username" data-rel="tooltip">
								<span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span10" name="login" id="login" type="text" value="admin" />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Password" data-rel="tooltip">
								<span class="add-on"><i class="icon-lock"></i></span><input class="input-large span10" name="password" id="password" type="password" value="admin123456" />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend">
							<label class="remember" for="remember"><input type="checkbox" id="remember" />Remember me</label>
							</div>
							<div class="clearfix"></div>

							<p class="center span5">
							<button type="submit" name="sign-in-btn" class="btn btn-primary">Login</button>
							</p>
						</fieldset>
					</form>
				</div><!--/span-->
			</div><!--/row-->
<?php include('footer.php'); ?>
