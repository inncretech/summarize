
<!-- Modal -->
<div id="signInModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
    <h3 id="myModalLabel">Sign in <span id="sign-in-modal-error"></span></h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="sign-in-form">
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="login">Username</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" id="login" placeholder="Username">
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="password">Password</label>
		<div class="controls">
		  <input class="input-xlarge" type="password" id="password" placeholder="Password">
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<div class="controls">
		  <label class="checkbox">
			<input type="checkbox"> Remember me
		  </label>
		  <button type="submit" class="btn" onclick="return false;" id="sign-in-btn">Sign in</button>
		</div>
	  </div>
	</form>
  </div>
  <div class="modal-footer">
	<button class="btn btn-primary">Facebook</button>
	<button class="btn btn-primary">Twitter</button>
	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
