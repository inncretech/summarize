<?php 
session_start();
include "include/database.php";
include "include/memcached.php";

//EMAIL VALIDATION FUNCTION
function EmailValidation($email) { 
		$email = htmlspecialchars(stripslashes(strip_tags($email))); //parse unnecessary characters to prevent exploits
		if ( eregi ( '[a-z||0-9]@[a-z||0-9].[a-z]', $email ) ) 
		{ //checks to make sure the email address is in a valid format
			$domain = explode( "@", $email ); //get the domain name
			if ( @fsockopen ($domain[1],80,$errno,$errstr,3)) {
				//if the connection can be established, the email address is probabley valid
				return true;
			} else {
				return false; //if a connection cannot be established return false
			}
		} else {
			return false; //if email address is an invalid format return false
		}
}

//PROFILE UPDATE @ TWITTER
if (isset($_POST['email-tw']))
{
	if(EmailValidation($_POST['email-tw'])==true)
	{
		$database->query("UPDATE users SET `email`='".$_POST['email-tw']."'where `uid`='".$_SESSION['uid']."' ");
		$_SESSION['email'] = $_POST['email-tw'];
		if (isset($_POST['gender'])) $database->query("UPDATE users SET `gender`='".$_POST['gender']."'where `uid`='".$_SESSION['uid']."' ");
		$password=time();
		$database->query("UPDATE users SET `password`='".$password."'where `uid`='".$_SESSION['uid']."' ");
		$database->sendEmail($_POST['email-tw'],"Registration","Welcome to Summarize!\n\r Username: ".$_POST['username']."\n\r Password:".md5($password));
		Redirect("profile.php");
	}
}
//forgotpass
if (isset($_POST['forgotpassbtn']))
{
	$database->getForgotPassCredentials($_POST['eMail'], $_POST['que'], $_POST['security']);
}

//PRODUCT ?????
if (isset($_POST['register']))
{	
	$database->addNewUser("normal",$_POST['username'],$_POST['email'], $_POST['fname'],$_POST['lname'],$_POST['gender'],$_POST['password'],$_POST['location'],'images/user-no-pic.png', $_POST['que'], $_POST['ans']);
	Redirect("login.php");
}

//PRODUCT ?????
if (isset($_POST['loginBtn']))
{	
	$data = $database->query("SELECT * FROM users WHERE username='".$_POST['username']."' AND (password='".md5($_POST['password'])."' OR password='".$_POST['password']."')");
	if (mysql_num_rows($data)>0){
		$data=mysql_fetch_array($data); 
		$_SESSION['uid']=$data['uid'];
		$_SESSION['username']=$data['username'];
		$_SESSION['email']=$data['email']; 
		$_SESSION['photo']=$data['profileimageurl'];
		$_SESSION['login']="normal";
		Redirect('index.php');
	}
	
}


if (isset($_POST['register']))
{	
	
}

//SAVE CATEGORY
if (isset($_POST['saveCat']))
{	
	$database->saveCategory($_POST['pname'],$_POST['name'],$_POST['pid']);
}


//SAVE TAGS
if (isset($_POST['saveTag']))
{	
	if (isset($_SESSION['uid']))
	{
		$database->saveTag($_POST['idproduct'],$_POST['tag']);
		$database->addPoints($database->getUID($_SESSION['username']),$_POST['idproduct'],"tag",TAG_POINTS);
		//Memcached
		$data = $database->query("select * from (SELECT count(pid) as rank,pid, @rownum := @rownum + 1 AS position FROM `search_rank` JOIN (SELECT @rownum := 0) as r group by pid order by rank desc  LIMIT 0,".MEMCACHED_RANK.") as t where pid='".$_POST['idproduct']."'");
		if (mysql_num_rows($data)>0){
			$memcachedServers=explode(",",MEMCACHED_HOSTS);
			$memcached = new MemcachedCon($memcachedServers,MEMCACHED_PORT);
			$memcached->replaceProductDetails($_POST['idproduct'],$database->getProdDetails($_POST['idproduct']));
		}
		//Memcached
	}else{
		echo "redirect";
	}
}

//DELETE TAG
if (isset($_POST['deleteTag']))
{	
	if (isset($_SESSION['uid']))
	{
		$database->deleteTag($_POST['idproduct'],$_POST['tag']);
		//Memcached
		$data = $database->query("select * from (SELECT count(pid) as rank,pid, @rownum := @rownum + 1 AS position FROM `search_rank` JOIN (SELECT @rownum := 0) as r group by pid order by rank desc  LIMIT 0,".MEMCACHED_RANK.") as t where pid='".$_POST['idproduct']."'");
		if (mysql_num_rows($data)>0){
			$memcachedServers=explode(",",MEMCACHED_HOSTS);
			$memcached = new MemcachedCon($memcachedServers,MEMCACHED_PORT);
			$memcached->replaceProductDetails($_POST['idproduct'],$database->getProdDetails($_POST['idproduct']));
		}
		//Memcached
	}else{
		echo "redirect";
	}
}

//ADD FEEDBACK

if (isset($_POST['addFeedback']))
{	
	if (isset($_SESSION['uid']))
	{
		$_POST['category'] = str_replace("", "", $_POST['category']);
		$type=$_POST['type'];
		if ($_POST['type']==''){$type='bad';}
		if ($_POST['type']=='on'){$type='good';}
		$database->addFeedback($_POST['category'],$_POST['feed'],$type,$_POST['id']);
		$database->addPoints($database->getUID($_SESSION['username']),$_POST['id'],"feedback",FEEDBACK_POINTS);
		$database->addActivity($_SESSION['uid'], $_POST['id'], "Feedback", "Category ".$_POST['category'].", ".$_POST['feed'] , $_POST['name'] );
		$data = $database->query("SELECT MAX(id) AS id FROM `feedback` ");
		$info = mysql_fetch_array($data);
		$feedback = $_POST;
		$feedback['idfeed'] = $info['id'];
		//Memcached
		$data = $database->query("select * from (SELECT count(pid) as rank,pid, @rownum := @rownum + 1 AS position FROM `search_rank` JOIN (SELECT @rownum := 0) as r group by pid order by rank desc  LIMIT 0,".MEMCACHED_RANK.") as t where pid='".$_POST['idproduct']."'");
		if (mysql_num_rows($data)>0){
			$memcachedServers=explode(",",MEMCACHED_HOSTS);
			$memcached = new MemcachedCon($memcachedServers,MEMCACHED_PORT);
			$memcached->replaceProductCategories($_POST['idproduct'],$database->getProdCategories($_POST['idproduct']));
			$memcached->addProductFeedback($_POST['idproduct'],$_POST['category'],$_POST['feed']);
		}
		//Memcached
		echo json_encode($feedback);
	}else{
		echo 'redirect';
	}
}

//ADD LIKE
if (isset($_GET['addLike']))
{	
	if (isset($_SESSION['uid']))
	{
		$data=$database->query("SELECT * FROM users where uid='".$_SESSION['uid']."'");
		$data=mysql_fetch_array($data);
		$database->addLike($_GET['idfeedback']);
		$database->addPoints($database->getUID($data['username']),$database->getPIDofLike($_GET['idfeedback']),"like",LIKE_POINTS);
		echo $database->getLikes($_GET['idfeedback']);
	} else { 
		echo 'login.php?msg=al&id='.$_GET['id'];
	}
}


if (isset($_POST['updUser']))
{	
	if (isset($_SESSION['uid']))
	{
		$database->userUpdate($_POST['fname'], $_POST['lname'], $_POST['email'],$_POST['location'],$_POST['gender']);
	}else{
		echo 'redirect';
	}
}


//PRODUCT SEARCH
if (isset($_POST['search']))
{	
	$search = explode(",", $_POST['q']);
	Redirect($database->verify(trim($search[0])));
}

//ADD PRODUCT
if (isset($_POST['addproduct']))
{	
	if ($_POST['img']!=''){$database->addProduct($_POST['name'],$_POST['tags'],$_POST['comment'],1);}
								else{$database->addProduct($_POST['name'],$_POST['tags'],$_POST['comment'],0);}
	$data=$database->query("SELECT * FROM product WHERE `name`='".$_POST['name']."'");
	$info=mysql_fetch_array($data);
	$database->addPoints($database->getUID($_SESSION['username']),$info['idproduct'],"product",PRODUCT_POINTS);
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = end(explode(".", $_POST['img']));
	include "include/SimpleImage.php";
	$image = new SimpleImage();
	$image->load($_POST['img']);
	if (($image->getWidth())>500)
	{
		$image->resizeToWidth(500);
	}
	$image->save("upload/" . $info['idproduct'].".".$extension);

	$d=$database->query("SELECT * FROM product ORDER BY `idproduct` DESC");
	$i=mysql_fetch_array($d);
	$type=$_POST['typeFeed'];
	
	if ($type=='on'){$type='good';}
	if ($type==''){$type='bad';}
	$database->query("insert into notifications_follow (`uid`,`product`,`date`) values('".$_SESSION['uid']."','".$i['idproduct']."',NOW())");
	$database->addFeedback($_POST['catFeed'],$_POST['feed'],$type,$i['idproduct']);
	echo "result.php?id=".$i['idproduct'];
}

//ADD IMG

if (isset($_POST['upload-image']))
{	
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	if (in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		}
	    else
		{
			if (file_exists("upload/" . $_FILES["file"]["name"]))
			{
			 // echo $_FILES["file"]["name"] . " already exists. ";
			}
			else
			{
				include "include/SimpleImage.php";
				$image = new SimpleImage();
				$image->load($_FILES["file"]["tmp_name"]);
				if (($image->getWidth())>500)
				{
					$image->resizeToWidth(500);
				}
				$image->save("upload/" . $_POST['id'].".".$extension);
			}
		}
	}
	else
	{
		//Invalid file.
	}
	Redirect("result.php?id=".$_POST['id']);
}



//LOGOUT

if (isset($_POST['logout']))
{	
	if ($_SESSION['login']=='normal'){
	session_destroy();
	}else{
	$logouturl=$_SESSION['logouturl'];
	$twitter=$_SESSION['twitter'];
	session_destroy();
	if ( ($logouturl) && ($twitter==0)) Redirect($logouturl);
	}
	Redirect("index.php");
}
 
function objectToArray($d) 
{
	if (is_object($d)) 
	{
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}
	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	}
	else {
		// Return array
		return $d;
	}
}
 
//FOLLOW PRODUCT

if ((isset($_GET['action'])) && (isset($_GET['p']))){
	$follow_uid=$_SESSION['uid'];
	$id=$_GET['p'];
	if($_GET['action']==0){
		$database->query("delete from notifications_follow where uid='$follow_uid' and product='$id'");
	} else {
		$date='now()';
		if(isset($_GET['date'])){
			$date="'".$_GET['date']."'";
		}
		$database->query("insert into notifications_follow (`uid`,`product`,`date`) values('$follow_uid','$id',$date)");
	}
}

// @ TWITTER LOGIN

if( (!empty($_GET['oauth_verifier'])) && (!empty($_SESSION['oauth_token'])) && (!empty($_SESSION['oauth_token_secret'])))
{  
	require "include/twitteroauth.php"; 
    // We've got everything we need  
	$twitteroauth = new TwitterOAuth(TW_APP_ID, TW_APP_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);  
	// Let's request the access token  
	$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
	// Save it in a session var 
	$_SESSION['access_token'] = $access_token; 
	// Let's get the user's info 
	$user_info = $twitteroauth->get('account/verify_credentials'); 
	// Print user's info  
	$user_info =objectToArray($user_info);
	$username=$user_info['screen_name'];
	$names=explode(" ",$user_info['name']);
	
	if (!$database->userNameTaken($username))
	{
		
		$database->addNewUser("twitter",$username,null,$names[0],$names[1],null,null,$user_info['location'],$user_info['profile_image_url'],null,null);
	}
	$database->query("UPDATE users SET `profileimageurl`='".$user_info['profile_image_url']."' , `currentlocation`='".$user_info['location']."' WHERE `username`='".$user_info['screen_name']."'");
	$_SESSION['username']=$username;
	$_SESSION['uid']=$database->getUID($_SESSION['username']);
	$_SESSION['twitter']="1";
	$_SESSION['photo']=$user_info["profile_image_url_https"];
	$_SESSION['login']="twitter";
	Redirect('profile.php');
}   

if ((empty($_POST))&&(empty($_GET))){
	Redirect("index.php");
}
?>