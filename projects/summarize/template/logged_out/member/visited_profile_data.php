<div class="page-header">
	<h1>Account Settings</h1>
  </div>
  <div class="alert alert-info">
            <strong>Short bio:</strong>
            <?=$visited_member_data['info']["short_bio"];?>
          </div>

<hr>	
<form class="form-horizontal" > 
  <div class="control-group">
	<label class="control-label" for="inputEmail">Display Name</label>
	<div class="controls">
	  <input type="text" id="inputEmail" value="<?=$visited_member_data["login"];?>" readonly>
	</div>
  </div>
  <div class="control-group">
	<label class="control-label" for="inputEmail">First Name</label>
	<div class="controls">
	  <input type="text" id="inputEmail" value="<?=$visited_member_data['info']["first_name"];?>" readonly>
	</div>
  </div>
  <div class="control-group">
	<label class="control-label" for="inputEmail" >Last Name</label>
	<div class="controls">
	  <input type="text" id="inputEmail" value="<?=$visited_member_data['info']["last_name"];?>" readonly>
	</div>
  </div>
  <div class="control-group">
	<label class="control-label" for="inputEmail" >Email</label>
	<div class="controls">
	  <input type="text" id="inputEmail" value="<?=$visited_member_data['info']["email"];?>" readonly>
	</div>
  </div>

</form>