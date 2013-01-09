<?php 
session_start(); 
include "include/database.php";
if (isset($_SESSION['uid'])){ Redirect('index.php');}
///twitter
require "include/twitteroauth.php";
$twitteroauth = new TwitterOAuth(TW_APP_ID, TW_APP_SECRET);  
$request_token = $twitteroauth->getRequestToken('http://projects.codemyworld.com/summarize/process.php');  
// Saving them into the session  
$_SESSION['oauth_token'] = $request_token['oauth_token'];  
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret']; 

  
// If everything goes well..
if (array_key_exists('twitter',$_GET)){  
	$logintiwtter=$_GET['twitter'];
	if ($logintiwtter)
	if($twitteroauth->http_code==200){  
		// Let's generate the URL and redirect  
		$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']); 
		Redirect($url); 
	} else { 
		// It's a bad idea to kill the script, but we've got to know when there's an error.  
		die('Something wrong happened.');  
	}  
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include "include/header.php"; ?>
	<body>
     
       <?php include "include/searchbox.php"; ?>
  
      <div id="container">
        <div id="innercontainer">
          <div class="summary" style="width:900px;">
		   <span id="title">Please login:</span>
				  <div id="block" style="margin-bottom:5px;"></div>
				  <form method='post' action='process.php'>
				  <table>
				  <tr>
				  <td>
				  <input type='text' name='username' style='margin-bottom:5px;' placeholder='Username...'>
				  </td></tr><tr><td>
				  <input type='password' name='password' style='margin-bottom:5px;' placeholder='Password...'>
				  </td></tr>
				  <tr><td>
				  <button name='loginBtn' class="btn btn-primary start"><i class="icon-user icon-white"></i><span>Login</span></button>
				  <button onclick="window.location.href='register.php';return false;" class="btn btn-success start"><i class="icon-user icon-white"></i><span>Register</span></button>
				  <tr><td>
				  <button onclick="window.location.href='forgotPass.php';return false;" class="btn btn-success start"><i class="icon-user icon-white"></i><span>Forgot Password</span></button>
				  </td></tr>
				  
				  </td></tr>
				  </table>
				  </form>
				   <div id="block" style="margin-bottom:5px;"></div>
				
			     <?php if ($user) { ?>
					<?php 
					//check if in database
					$email=$user_profile['email'];
					if ($database->userNameTaken($user_profile['username'])){
								//proc login
								$_SESSION['email']=$email;
								$_SESSION['username']=$user_profile['username'];
								$_SESSION['login']="facebook";
								$_SESSION['photo']="https://graph.facebook.com/".$user."/picture";
								$database->query("UPDATE users SET `currentlocation`='".$user_profile['location']['name']."', `profileimageurl` = 'https://graph.facebook.com/".$_SESSION['username']."/picture', `fname`='".$user_profile['first_name']."' , `lname`='".$user_profile['last_name']."' , `logintype`='facebook' ,`gender`='".$user_profile['gender']."' WHERE `username`='".$user_profile['username']."'");
							
					} else {
						//else create account
						$username=$user_profile['username'];
						$database->addNewUser("facebook",$username,$email,$user_profile['first_name'],$user_profile['last_name'],$user_profile['gender'],null,$user_profile['location']['name'],"https://graph.facebook.com/".$user."/picture",null,null);
						$_SESSION['email']=$email;
						$_SESSION['username']=$user_profile['username'];
						$_SESSION['photo']="https://graph.facebook.com/".$user."/picture";
						$_SESSION['login']="facebook";
					
					};
					$_SESSION['uid']=$database->getUID($_SESSION['username']);
					Redirect('index.php');

					?>
				  </pre>
				<?php } else { ?>
				 <a href="<?php echo  $loginUrl;?>" style="float:left;margin-right:5px;"><img src="images/fb-login.jpg" ></a>
				<?php } ?>
				
				<div id="twitter" style="float:left;"> <a href="login.php?twitter=yes"> <img src="images/login-twitter.jpg" ></a></div>
           
        </div>
	  </div>
    </div>
</body>
</html>
