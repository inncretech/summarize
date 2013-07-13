
<!-- Modal -->
<div id="signInModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
      <h2 id="addProductLabel">Sign In 
      <div class="social_signin">
		<a href="<?=SITE_ROOT;?>/backend/facebook/login-facebook.php" class="btn btn-facebook"><i class="icon icon-facebook">&nbsp;</i> Use Facebook</a>
        <a href="<?=SITE_ROOT;?>/backend/twitter/login-twitter.php" class="btn btn-twitter"><i class="icon icon-twitter">&nbsp;</i> Use Twitter</a>
      </div>
      </h2>
    </div>
  
	<div class="modal-body grey">
	<div id="sign-in-modal-error" style="display:none;margin-bottom: 10px;">
		<div class="alert alert-danger" id="product-error" style="margin-bottom: 0px;">
		<strong>Ups!</strong> Invalid Credentials.
		</div>
	</div>
	  <form class="form-horizontal" id="sign-in-form">
		<div class="control-group"  style="margin-bottom: 10px">
		  <label class="control-label" for="inputLogin">Login</label>
		  <div class="controls">
			<input type="text"  id="login" placeholder="Login">
		  </div>
		</div>
		<div class="control-group" style="margin-bottom: 10px">
		  <label class="control-label" for="inputPassword">Password</label>
		  <div class="controls">
			<input type="password"  id="password" placeholder="Password">
		  </div>
		</div>
		<div class="control-group">

		  <div class="controls" >
			<button type="submit" class="btn btn-primary" style="width: 220px;" onclick="return false;" id="sign-in-btn">Login to your account</button>
			<p></p>
			<a href="#forgotModal" role="button" style="width: 220px;" data-dismiss="modal" data-toggle="modal">Forgot password?</a>
			
		  </div>
		</div>
		<hr>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Not Yet Registered</label>
		  <div class="controls">
			<button type="submit" href="#registerModal" role="button" class="btn btn-primary" style="width: 220px;" data-dismiss="modal" data-toggle="modal">Register Now</button>
		  </div>
		</div>
	  </form>
	</div>
</div>

<div id="forgotModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
      <h2 id="addProductLabel">Forgot Password 
      </h2>
    </div>
  
	<div class="modal-body grey">
	<div id="forgot-success" style="display:none;margin-bottom: 10px;">
		<div class="alert alert-success" id="product-error" style="margin-bottom: 0px;">
		<strong>Email Sent</strong>
		</div>
	</div>
	<div id="forgot-error" style="display:none;margin-bottom: 10px;">
		<div class="alert alert-danger" id="product-error" style="margin-bottom: 0px;">
		<strong>Invalid Login or Email</strong>
		</div>
	</div>

	  <form class="form-horizontal">
		<div class="control-group"  style="margin-bottom: 10px">
		  <label class="control-label" for="inputLogin">Login</label>
		  <div class="controls">
			<input type="text"  id="forgot-login" placeholder="Login">
		  </div>
		</div>
		<div class="control-group"  style="margin-bottom: 10px">
		  <label class="control-label" ></label>
		  <div class="controls">
			<strong>or</strong>
		  </div>
		</div>
		<div class="control-group"  style="margin-bottom: 10px">
		  <label class="control-label" >Email</label>
		  <div class="controls">
			<input type="text"  id="forgot-email" placeholder="Email">
		  </div>
		</div>
		<div class="control-group">

		  <div class="controls">
			<button type="submit" class="btn btn-primary" id="forgot-trigger" style="width: 220px;" onclick="return false;" >Retrive Password</button>
		  </div>
		</div>
	  </form>
	</div>
</div>
