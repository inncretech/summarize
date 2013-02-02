<div id="registerModal" style="width: 70%;left:35%;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
    <h3 id="register-modal-header">Register <span id="register-modal-error"></span></h3>
  </div>
  <div class="modal-body" style="max-height:405px;">
    <form class="form-horizontal" id="register-form" method="POST" action="backend/ajax.post/add_member.php">
	<table>
	<tr>
	<td valign="top">
	
	<div style="float:left;width: 500px;">
	<div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="first_name">First Name</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" style="width:272px" name="first_name" id="first_name" placeholder="First Name" autocomplete="off" value="<?=$facebook->data['first_name'];?>">
		</div>
	  </div>
		<div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="last_name">Last Name</label>
		<div class="controls">
		  <input class="input-xlarge" type="text" style="width:272px" name="last_name" id="last_name" placeholder="Last Name" autocomplete="off" value="<?=$facebook->data['last_name'];?>">
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="email">Email</label>
		
		<div class="controls">
		  <input class="input-xlarge" style="width:272px;float:left;" type="text" name="email" id="email" placeholder="Email" autocomplete="off" value="<?=$facebook->data['email'];?>">
		  <img class="email-check" style="float:right;display:none;height:30px">
		</div>
	  </div>
	  <div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="short_bio">Short bio</label>
		<div class="controls">
		  <textarea class="input-xlarge" style="width:272px" name="short_bio" id="short_bio" rows="2" ></textarea>
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
		  <input class="input-xlarge" type="text" name="secret_answer1_hash" style="width:272px" id="secret_answer1_hash" placeholder="Answer" autocomplete="off">
		</div>
	  </div>
	 
	  <div class="control-group" style='margin-bottom: 10px;'>
		<div class="controls">
		  <button type="submit" class="btn" onclick="return false;" id="register-btn">Register</button>
		</div>
	  </div>
	  
	</td>
		<td valign="top">
		<div>
		<input class="input-xlarge" type="text" style="width:272px;float:left;margin: 0 0 5px 33px;" name="login" id="login" placeholder="Username" autocomplete="off" value="<?=$facebook->data['username'];?>">
		 <img class="login-check" style="float:left;display:none;margin: 0 30px 0 0;height:30px">
		 </div>
		 <div>
		  <input class="input-xlarge" type="password" style="width:272px;float:left;margin: 5px 0 5px 33px;" name="password" id="regpassword" placeholder="Password" autocomplete="off">
		  <input class="input-xlarge" type="password" style="width:272px;float:left;margin: 5px 0 5px 33px;" name="repassword" id="repassword" placeholder="Re-password" autocomplete="off">
		  <img class="password-check" style="float:left;display:none;height:30px">
		 </div>
			<div class="control-group" style='margin-bottom: 10px;'>
		<label class="control-label" for="captcha_div"></label>
		<div class="controls" style="margin:  0 0 30px;" id="captcha_div">
		  
		</div>
	  </div>
	   
		  
	
		</td>
	</tr>
	</table>
	</form>
	
  </div>
  <div class="modal-body grey">
	
	
	<a href="index.php?sign_out=true" class="btn" <?php if (!$facebook->check) echo 'data-dismiss="modal"';?>  aria-hidden="true" style="float:right;margin-right:5px;">Close</a>
	<a class="btn btn-primary" style="float:right;margin-right:5px;">Twitter</a>
	<a href="<?=$facebook->loginUrl;?>" class="btn btn-primary" style="float:right;margin-right:5px;">Facebook</a>
  </div>
</div>