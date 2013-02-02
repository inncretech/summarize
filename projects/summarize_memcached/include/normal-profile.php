<div class='user-table'>
<span id='title'>Account Settings:</span>
<div id='block'></div>
<table id='user-table'>
	<tr><td><div id="table-title">Username</div></td><td ><input style="width:300px;margin-bottom:0px;"  readonly='readonly' id='username' type="text"  value="<?=$data['username'];?>"/></td></tr>
	<tr><td><div id="table-title">Email</div></td><td><input style='width:300px;margin-bottom:0px;'  id='email' value='<?=$data['email'];?>' type='text' /></td></tr>
	<tr><td><div id="table-title">First name</div></td><td><input style="width:300px;margin-bottom:0px;"   id='fname'  type="text"  value="<?=$data['fname'];?>"  /></td></tr>
	<tr><td><div id="table-title">Last name</div></td><td><input style="width:300px;margin-bottom:0px;"   id='lname'  type="text"  value="<?=$data['lname'];?>"  /></td></tr>
	<tr><td><div id="table-title">Location</div></td><td><input style="width:300px;margin-bottom:0px;"   id='location'  type="text"  value="<?=$data['currentlocation'];?>"  /></td></tr>
	<tr><td><div id="table-title">Gender</div></td><td><select id='gender'><option value="<?=$data['gender'];?>"><?=$data['gender'];?></option>
			<option value="<?php if ("female"==$data['gender']) echo "male"; else echo "female";?>"><?php if ("female"==$data['gender']) echo "male"; else echo "female";?></option>
			</select></td></tr>
	<tr><td></td><td><button  onclick="updateUser()" class="btn btn-primary start"><i class="icon-upload icon-white"></i><span>Update</span></button></td></tr>
	</table>
	
</div>
<script>
function updateUser(){
$.post('process.php', {updUser:true, email: $("#email").val(),fname: $("#fname").val(),lname: $("#lname").val(), location: $("#location").val(),gender: $("#gender").val() }, function(data){if(data=='redirect') {window.location.href='login.php'} else {  }});
}
</script>