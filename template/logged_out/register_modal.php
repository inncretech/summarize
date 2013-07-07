<div id="registerModal"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
      <h2 id="addProductLabel">Sign Up
      <div class="social_signin">
		<a href="<?=SITE_ROOT;?>/backend/facebook/login-facebook.php" class="btn btn-facebook"><i class="icon icon-facebook">&nbsp;</i> Use Facebook</a>
        <a href="<?=SITE_ROOT;?>/backend/twitter/login-twitter.php" class="btn btn-twitter"><i class="icon icon-twitter">&nbsp;</i> Use Twitter</a>
      </div>
      </h2>
	  <div class="form-horizontal" id="register-text" style="text-align: center;">
		You can easily sign up using your social network account with just one click.
	</div>
  </div>
  <div class="modal-body grey">
	
	
	<form class="form-horizontal" id="register-form"  method="POST" action="<?=SITE_ROOT;?>/backend/ajax.post/add_member.php" autocomplete="off">
		<input type="hidden" name="image" value="<?=(($session->getValue("social_network_name")!="facebook") && ($session->getValue("social_network_name")!="twitter")) ? SITE_ROOT."/images/default.png" : ""?><?=($session->getValue("social_network_name")=="facebook" ? 'https://graph.facebook.com/'.$member_data['social_network_data']['id'].'/picture?type=large' : $member_data['social_network_data']['profile_image_url']);?>">
		 <input class="input-xlarge" type="hidden" style="width:272px" name="first_name" id="first_name" placeholder="First Name" autocomplete="off" value="<?=(($session->getValue("social_network_name")!="facebook") && ($session->getValue("social_network_name")!="twitter")) ? "First Name" : ""?><?=($session->getValue("social_network_name")=="facebook" ? $member_data['social_network_data']['first_name'] : array_shift(explode(" ",$member_data['social_network_data']["name"])));?>">
		 <input class="input-xlarge" type="hidden" style="width:272px" name="last_name" id="last_name" placeholder="First Name" autocomplete="off" value="<?=(($session->getValue("social_network_name")!="facebook") && ($session->getValue("social_network_name")!="twitter")) ? "Last Name" : ""?><?=($session->getValue("social_network_name")=="facebook" ? $member_data['social_network_data']['last_name'] : array_pop(explode(" ",$member_data['social_network_data']["name"])));?>">
		<div class="control-group" style="margin-bottom: 10px">
		  <label class="control-label" for="inputEmail">Email</label>
		  <div class="controls">
			<input class="input-xlarge" style="width:272px;float: left;" type="text" name="email" id="email" placeholder="Email" autocomplete="off" value="<?=$member_data['social_network_data']['email'];?>">
			<img class="email-check" style="display:none;height:30px">
		  </div>
		</div>
		<div class="control-group" style="margin-bottom: 10px">
		  <label class="control-label" for="inputLogin">Login</label>
		  <div class="controls">
			<input class="input-xlarge" type="text" style="width:272px;float: left;" name="login" id="login" placeholder="Username" autocomplete="off" value="<?php if($session->getValue("social_network_name")=="facebook"){echo $member_data['social_network_data']['username'];}else{if ($session->getValue("social_network_name")=="twitter"){echo $member_data['social_network_data']['screen_name'];}}?>">
		 <img class="login-check" style="float:left;display:none;height:30px">
		  </div>
		</div>
		<div class="control-group" style="margin-bottom: 10px">
		  <label class="control-label" for="inputPassword">Password</label>
		  <div class="controls">
			<input class="input-xlarge" type="password" style="width:272px;float: left;" name="password" id="regpassword" placeholder="Password" autocomplete="off">
		  </div>
		</div>
		<div class="control-group" style="margin-bottom: 10px">
		  <label class="control-label" for="inputRePassword">Re-Password</label>
		  <div class="controls">
			<input class="input-xlarge" type="password" style="width:272px;float: left;" name="repassword" id="repassword" placeholder="Re-password" autocomplete="off">
		  <img class="password-check" style="float:left;display:none;height:30px">
		  </div>
		</div>
		<div class="control-group">
		  <div class="controls">
			

			<button type="submit" class="btn btn-primary" onclick="return false;" id="register-btn">Register</button>
			<a href="index.php?sign_out=true" class="btn" <?php if ((!$session->getValue("social_network_name")=="facebook")||(!$session->getValue("social_network_name")=="twitter")) echo 'data-dismiss="modal"';?>  aria-hidden="true" style="margin-right:5px;">Close</a>
		  </div>
		</div>
	  </form>
    <div class="form-horizontal" id="register-text" style="text-align: center;">
		By creating an account, I accept Summarizit's <a>Terms of Service</a> and <a>Privacy Policy</a>.
	</div>
	
  </div>
</div>

