<?php 
session_start(); 
include "include/database.php";
if (isset($_SESSION['uid'])){ Redirect('index.php');}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include "include/header.php"; ?>
	<body>
     
       <?php include "include/searchbox.php"; ?>
	   
      <div id="container">
        <div id="innercontainer">
          <div class="summary" style="width:900px;">
		   <span id="title">Fill the required fields to retrieve your password:</span>
				  <div id="block" style="margin-bottom:5px;"></div>
				  <form method='post' action='process.php'>
					<style type="text/css">#notdone{display:none;} #done{display:none}</style>
				  <table>
				  <tr><td>
					<? $params = $_SERVER['QUERY_STRING'] ;
						   
						   if ($params=="e=1"){
						    ?>
						   <style type="text/css">#done{display:inline;}</style>
						   <?php 
						   } 
							else if($params == "e=0")
							 {?>
							<style type="text/css">#notdone{display:inline;}</style>
							<?php }
						   ?>	
				  <div id='done'>
							<p>An email has been sent you containing your password</p>
				  </div>
				  <div id='notdone'>
							<p>The combination of email, security question and answer is not right, try again !</p>
				  </div>
				  </td></tr>
				  <tr>
				  <td>
				  <input type='text' name='eMail' style='margin-bottom:5px;' placeholder='eMail...'>
				  </td></tr>
					<tr>
					<td>
					<select name='que' style='margin-bottom:5px;width:260px'>
						<option value="What is the name of your first pet?">What is the name of your first pet?</option>
						<option value="What year you were born?">What year you were born?</option>
						<option value="What is your mother's name?">What is your mother's name?</option>
					</select>
					</td>
					</tr>
					
				  <tr><td>
				  <input type='text' name='security' style='margin-bottom:5px;' placeholder='Answer to security question...'>
				  </td></tr>
				  <tr><td>
				  <button name='forgotpassbtn' class="btn btn-primary start"><i class="icon-user icon-white"></i><span>Retrieve Password</span></button>
				  </td></tr>
				  </table>
				  </form>
				   <div id="block" style="margin-bottom:5px;"></div>
				
			     
           
        </div>
	  </div>
    </div>
</body>
</html>
