<?php 
session_start(); 
include "include/database.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include "include/header.php"; ?>
	<body>
     
       <?php include "include/searchbox.php"; ?>
  
      <div id="container" >
        <div id="innercontainer">
            <div class="summary" style="width:900px;">
				<div id="title">Register:</div>
				<div id='block'></div>
				<form action="process.php" method="post">
				<table>
				<tr>
				<td>
				<input type="text" name='fname' placeholder="First Name..." style="margin-bottom:5px;width:250px">
				</td>
				</tr>
				<tr>
				<td>
				<input type="text" name='lname' placeholder="Last Name..." style="margin-bottom:5px;width:250px">
				</td>
				</tr>
				<tr>
				<td>
				<select name='gender' style="margin-bottom:5px;width:260px"><option value='male'>Male</option><option value='female'>Female</option></select>
				</td>
				</tr>
				<tr>
				<td>
				<input type="text" name='location' placeholder="Location..." style="margin-bottom:5px;width:250px">
				</td>
				</tr>
				<tr>
				<td>
				<input type="text" name='username' placeholder="Username..." style="margin-bottom:5px;width:250px">
				</td>
				</tr>
				<tr>
				<td>
				<input type="text"  name='password' placeholder="Password..." style="margin-bottom:5px;width:250px">
				</td>
				</tr>
				<tr>
				<td>
				<select name='que' style='margin-bottom:5px;width:260px'>
					<option value="What is the name of your first pet?">What is the name of your first pet?</option>
					<option value="What year you were born?">What year you were born?</option>
					<option value="What is your mother's name?">What is your mother's name?</option>
				</select>
				</td>
				</tr>
				<tr>
				<td>
				<input type="text" name='ans' placeholder="Answer..." style="margin-bottom:5px;width:250px">
				</td>
				</tr>
				<tr>
				<td>
				<input type="text" name='email' placeholder="Email..." style="margin-bottom:5px;width:250px">
				</td>
				<td>
				</tr>
				<tr>
				<td>
				<button  class="btn btn-primary start" name="register"><i class="icon-upload icon-white"></i><span>Register</span></button>
				</td>
				<td>
				</tr>
				<table>
				</form>
			</div>
	  </div>
    </div>
</body>
</html>
