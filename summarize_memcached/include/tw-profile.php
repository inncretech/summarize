<form class='user-table' method='POST' name='edit' action='process.php' enctype='multipart/form-data'>
<span id='title'>Account Settings:</span>
<div id='block'></div>
<table id='user-table'>
	<tr><td><div id="table-title">Username</div></td><td><input style="width:300px;margin-bottom:0px;"   name='username' readonly="readonly" type="text"  value="<?=$data['username'];?>"  /></td></tr>
	<tr><td><div id="table-title">Email</div></td><td><input style="width:300px;margin-bottom:0px;"   name='email-tw' placeholder="Enter email..." value='<?=$data['email']?>' type='text' <?php if(($data['email']!='')||($page!='profile.php')) echo 'readonly="readonly"';?>/></td></tr>
	
    <tr><td><div id="table-title">First name</div></td><td><input style="width:300px;margin-bottom:0px;"   name='fname' readonly="readonly" type="text"  value="<?=$data['fname'];?>"  /></td></tr>
	<tr><td><div id="table-title">Last name</div></td><td><input style="width:300px;margin-bottom:0px;"   name='lname' readonly="readonly" type="text"  value="<?=$data['lname'];?>"  /></td></tr>
	<tr><td><div id="table-title">Location</div></td><td><input style="width:300px;margin-bottom:0px;"   name='location' readonly="readonly" type="text"  value="<?=$data['currentlocation'];?>"  /></td></tr>
	<?php if (($data['gender']=="")&&($page!='user.php'))
    	  echo("<tr><td><div id='table-title'>Gender</div></td><td><select name='gender' style='margin-bottom:0px;' ><option value='Male'>Male</option><option value='Female'>Female</option></select></td></tr>");
		  else
		  echo("<tr><td><div id='table-title'>Gender</div></td><td><input style='width:300px;margin-bottom:0px;'   name='username' readonly='readonly' type='text'  value='".$data['gender']."' /></td></tr>"); ?>
	<tr>
	<?if ((($data['email']=="")||($data['gender']==""))&&($page!='user.php')){?>
	<td></td><td>
	<button style="width:108px;" onclick='javascript:document.edit.submit();' class="btn btn-primary start"><i class="icon-upload icon-white"></i><span>Submit</span></button>
	</td></tr>
	<? } ?>
	</table>
</form>