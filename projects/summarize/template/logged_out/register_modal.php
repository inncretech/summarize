<div id="registerModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
    <h3 id="register-modal-header">Register <span id="register-modal-error"></span></h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="register-form" method="POST" action="backend/ajax.post/add_member.php">
	<div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="first_name">First Name</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" name="first_name" id="first_name" placeholder="First Name" autocomplete="off">
		</div>
	  </div>
		<div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="last_name">Last Name</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" name="last_name" id="last_name" placeholder="Last Name" autocomplete="off">
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="email">Email</label>
		
		<div class="controls">
		  <input class="input-xlarge" type="text" name="email" id="email" placeholder="Email" autocomplete="off">
		  <img class="email-check" style="float:right;display:none;margin: 0 30px 0 0;height:30px">
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="short_bio">Short bio</label>
		<div class="controls">
		  <textarea class="input-xlarge" name="short_bio" id="short_bio" rows="2" ></textarea>
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="login">Username</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" name="login" id="login" placeholder="Username" autocomplete="off">
		  <img class="login-check" style="float:right;display:none;margin: 0 30px 0 0;height:30px">
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="password">Password</label>
		<div class="controls">
		  <input class="input-xlarge" type="password" name="password" id="password" placeholder="Password" autocomplete="off">
		</div>
	  </div>
	   <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="ref_secret_question1_id">Secret Question</label>
		<div class="controls" id='secret-questions'>
			
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="secret_answer1_hash">Answer</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" name="secret_answer1_hash" id="secret_answer1_hash" placeholder="Answer" autocomplete="off">
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<div class="controls">
		  <button type="submit" class="btn" onclick="return false;" id="register-btn">Register</button>
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