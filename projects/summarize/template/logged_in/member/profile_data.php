<div class="page-header">
	<h1>Account Settings</h1>
  </div>
  
	<div class="alert alert-info" id="update-user-success" style="display:none;">
            <strong>Heads up!</strong>
            Your changes have been saved to the databse.
          </div>
		 
		  <div class="alert alert-danger" id="update-user-error" style="display:none;">
            <strong>Heads up!</strong>
            Some of the caracters you have entered are not valid, please check and try again.
          </div>
  <form class="form-horizontal" id="member-profile-page">
  <div class="control-group">
	<label class="control-label" for="login">Display Name</label>
	<div class="controls">
	  <input type="text" id="login" name="login" value="<?=$member_data["login"];?>">
	  <img  style="display:none;margin: 0 30px 0 0;height:30px">
	</div>
  </div>
  <div class="control-group">
	<label class="control-label" for="first_name">First Name</label>
	<div class="controls">
	  <input type="text" id="first_name" name="first_name" value="<?=$member_data['info']["first_name"];?>">
	</div>
  </div>
  <div class="control-group">
	<label class="control-label" for="last_name" >Last Name</label>
	<div class="controls">
	  <input type="text" id="last_name" name="last_name" value="<?=$member_data['info']["last_name"];?>">
	</div>
  </div>
  <div class="control-group">
	<label class="control-label" for="email" >Email</label>
	<div class="controls">
	  <input type="text" id="email" name="email" value="<?=$member_data['info']["email"];?>">
	  <img  style="display:none;margin: 0 30px 0 0;height:30px">
	</div>
  </div>
  <div class="control-group">
	<label class="control-label" for="short_bio" ">Short Bio</label>
	<div class="controls">
	  <textarea  style="width: 400px;height: 100px;" id="short_bio" name="short_bio"><?=$member_data['info']["short_bio"];?></textarea>
	</div>
  </div>
  <div class="control-group">
	<div class="controls">
	  <button type="submit" class="btn" id="update-member-btn" onclick="return false;">Save</button>
	</div>
  </div>
</form>