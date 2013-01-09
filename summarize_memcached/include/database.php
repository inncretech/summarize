<?
error_reporting(E_ALL ^ E_NOTICE);
require_once "constants.php"; 


class MySQLDB
{
   var $connection;         //The MySQL database connection

   /* Class constructor */
   function MySQLDB(){
      /* Make connection to database */
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
      mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
	  /*
      $data = mysql_query("SELECT * FROM constants ");
	  $info = mysql_fetch_array($data);
	  foreach ($info as $key => $value){
		if (($key!="admin_email")&&($key!="id"))
		define($key, $value);
	  }
	  */
   }

   /**
    * confirmUserPass - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given password is the same password in the database
    * for that user. If the user doesn't exist or if the
    * passwords don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUser($email, $password){
		$email = mysql_real_escape_string($email);
		$password = mysql_real_escape_string($password);
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $email = addslashes($email);
      }
      /* Verify that user is in database */
      $q = "SELECT * FROM users WHERE email = '$email'";
      $result = mysql_query($q, $this->connection);
      if(!$result || (mysql_numrows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve password from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);
      /* Validate that password is correct */
      if($password == $dbarray['password']){
         return 0; //Success! Username and password confirmed
      }
      else{
         return 2; //Indicates password failure
      }
   }
   
   
   /**
    * userEmailTaken - Returns true if the username has
    * been taken by another user, false otherwise.
    */
   function userEmailTaken($email){
	  $email = mysql_real_escape_string($email);
      if(!get_magic_quotes_gpc()){
         $email = addslashes($email);
      }
      $q = "SELECT email FROM users WHERE email = '$email'";
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   }
   
   function userUpdate($fname, $lname, $email, $loc, $gen){
   $fname = mysql_real_escape_string($fname);
   $lname = mysql_real_escape_string($lname);
   $loc = mysql_real_escape_string($loc);
   $gen = mysql_real_escape_string($gen);
   $email = mysql_real_escape_string($email);
   $quer="UPDATE users SET `email` = '".$email."' , `fname` = '".$fname."', `gender` = '".$gen."',`lname` = '".$lname."',`currentlocation` = '".$loc."' WHERE users.uid = '".$_SESSION['uid']."'" ;
   mysql_query($quer, $this->connection);
   }
   
   function updImg($uid,$ext){
   $uid = mysql_real_escape_string($uid);
   $quer="UPDATE users  SET `profileimageurl`='upload/".$uid.".".$ext."' WHERE uid = ".$uid;
   mysql_query($quer, $this->connection);
   }
   
   function userNameTaken($username){
	  $username = mysql_real_escape_string($username);
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT email FROM users WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   }

   /**
    * addNewUser - Inserts the given (username, password, email)
    * info into the database. Appropriate user level is set.
    * Returns true on success, false otherwise.
    */
   function addNewUser($logintype,$username,$email, $fname,$lname,$gender,$password,$location,$profileimageurl, $que, $ans){
	  $username = mysql_real_escape_string($username);
	  $email = mysql_real_escape_string($email);
	  $fname = mysql_real_escape_string($fname);
	  $lname = mysql_real_escape_string($lname);
	  $gender = mysql_real_escape_string($gender);
	  $hometown = mysql_real_escape_string($hometown);
	  $location = mysql_real_escape_string($location);
	  $que = mysql_real_escape_string($que);
	  $ans = mysql_real_escape_string($ans);
	  if ($password!=null){$password = md5(mysql_real_escape_string($password));}else{$password = md5(time());}
	  $profileimageurl = mysql_real_escape_string($profileimageurl);
      $q = "INSERT INTO users  (`uid` ,`logintype`,`username` ,`email` ,`fname`,`lname`,`gender`,`password`,`currentlocation`,`profileimageurl`, `que`, `ans` ) VALUES ( NULL, '".$logintype."', '".$username."', '".$email."', '".$fname."', '".$lname."' ,'".$gender."' ,'".$password."' ,'".$location."' , '".$profileimageurl."' ,'".$que."' ,'".$ans."')";
      if ($email!=null){$this->sendEmail($email,"Registration","Welcome to Summarize!\n\rUsername: ".$username."\n\r Password:".$password);}
	  return mysql_query($q, $this->connection);
   }
   function saveTag($idproduct, $tag){
      $idproduct = mysql_real_escape_string($idproduct); 
	  $tag = mysql_real_escape_string($tag); 
	  $data=mysql_query("select * from product where `idproduct`='$idproduct'", $this->connection);
	  $data=mysql_fetch_array($data);
	  $name=$data['name'];
	  $data_user=mysql_query("select * from users where `uid`='".$_SESSION['uid']."'", $this->connection);
	  $info_user=mysql_fetch_array($data_user);
	  $q2= "Insert into notifications (`uid`,`username`,`text`,`idproduct`,`date`) values ('".$info_user['uid']."','".$info_user['username']."','changed tags for','$idproduct',now());";
	  mysql_query($q2, $this->connection);
	  $tags = explode(",", str_replace(" ", "",$data['tags']));
	  array_push($tags,$tag);
	  $tags = array_filter(array_unique($tags));
	  $tags = join(", ", $tags);
      $q = "UPDATE product SET `tags` = '".$tags."' WHERE `idproduct` = '".$idproduct."'";
      return mysql_query($q, $this->connection);
   }
   
   function deleteTag($idproduct, $tag){
      $idproduct = mysql_real_escape_string($idproduct); 
	  $tag = mysql_real_escape_string($tag); 
	  $data=mysql_query("select * from product where `idproduct`='$idproduct'", $this->connection);
	  $data=mysql_fetch_array($data);
	  $name=$data['name'];
	  $data_user=mysql_query("select * from users where `uid`='".$_SESSION['uid']."'", $this->connection);
	  $info_user=mysql_fetch_array($data_user);
	  $q2= "Insert into notifications (`uid`,`username`,`text`,`idproduct`,`date`) values ('".$info_user['uid']."','".$info_user['username']."','changed tags for','$idproduct',now());";
	  mysql_query($q2, $this->connection);
	  $tags = explode(",", str_replace(str_replace(" ", "",$tag),"",str_replace(" ", "",$data['tags'])));
	  $tags = array_filter(array_unique($tags));
	  $tags = join(", ", $tags);
      $q = "UPDATE product SET `tags` = '".$tags."' WHERE `idproduct` = '".$idproduct."'";
      mysql_query($q, $this->connection);
   }
   
   function saveCategory($pName, $name,$pid){
      $idFeed = mysql_real_escape_string($idFeed); 
	  $name = mysql_real_escape_string($name); 
	  $q = "UPDATE `feedback` SET `category` = '".$name."' WHERE `category` = '".$pName."' AND `idproduct`='".$pid."'";
	  return mysql_query($q, $this->connection);
   }
   
   function getLikes($id){
	  $id = mysql_real_escape_string($id);
      $q = "SELECT * FROM feedback WHERE id=".$id;
      $data=mysql_query($q, $this->connection);
	  $info=mysql_fetch_array($data);
	  return $info['thumb'];
   }
   function verify($name){ 
	  $name = mysql_real_escape_string($name);
      $q = "SELECT * FROM product where name='".$name."'";
	  $data=mysql_query($q, $this->connection);
	  if(mysql_num_rows($data)>0){
	  $info=mysql_fetch_array($data);
	  $aux=explode(" ",$info['name']);
	  $aux=implode("-",$aux);
	  $q = "Insert into search_rank (`pid`) values ('".$info['idproduct']."')";
	  mysql_query($q, $this->connection);
	  
	  //Memcached
	  $data=mysql_query("select * from (SELECT count(pid) as rank,pid, @rownum := @rownum + 1 AS position FROM `search_rank` JOIN (SELECT @rownum := 0) as r group by pid order by rank desc  LIMIT 0,".MEMCACHED_RANK.") as t where pid='".$info['idproduct']."'",$this->connection);
	  
	  $item_to_delete= mysql_query("select * from (SELECT count(pid) as rank,pid, @rownum := @rownum + 1 AS position FROM `search_rank` JOIN (SELECT @rownum := 0) as r group by pid order by rank desc  LIMIT ".MEMCACHED_RANK.",1) as t ");
		 if (mysql_num_rows($item_to_delete)>0){
			$item_to_delete=mysql_fetch_array($item_to_delete);
			
		}
	  if (mysql_num_rows($data)>0){
			$data=mysql_fetch_array($data);
			$memcachedServers=explode(",",MEMCACHED_HOSTS);
			if (count($memcachedServers)>0){
			  $memcached = new MemcachedCon($memcachedServers,MEMCACHED_PORT);
			  $result = $memcached->connection->get($data['pid']);
			  if ($memcached->connection->getResultCode() == Memcached::RES_NOTFOUND) {
					if ($memcached->getCacheProdCount()> MEMCACHED_RANK){$memcached->deleteProduct($item_to_delete['pid']);}
					$details = $this->getProdDetails($data['pid']);
					$categories = $this->getProdCategories($data['pid']);
					$feedback = $this->getProdFeedback($data['pid']);
					$memcached->cacheProduct($data['pid'],$details,$categories,$feedback);
			  }
			}
	  }
	  //Memcached
	  
	  return $aux;
	  }
	  else{
	  return 'solr-client.php?q='.$name;
	  }

   }
   
   //Memcached
	function getProdDetails($pid){
		$data=mysql_query("SELECT * FROM product WHERE idproduct='".$pid."'", $this->connection);
		return mysql_fetch_array($data);
	}
	function getProdCategories($pid){
		$feedCategory = array();
		$fcData=mysql_query("SELECT DISTINCT `category` , id , (SELECT SUM(thumb) FROM feedback WHERE `idproduct` = '".$id."' AND category=f1.category AND type='good') as good ,(SELECT SUM(thumb) FROM feedback WHERE `idproduct` = '".$id."' AND category=f1.category AND type='bad') as bad FROM `feedback` as f1 WHERE `idproduct` = '".$id."' GROUP BY `category`", $this->connection); 
		$aux=0;
		while ($feedbackCategorys=mysql_fetch_array($fcData)){
			$feedCategory[$aux] = $feedbackCategorys;
			$aux=$aux+1;
		}
		return $feedCategory;
	}
	function getProdFeedback($pid){
		$feedback = array();
		$cat_data=mysql_query("SELECT DISTINCT `category` FROM `feedback` WHERE `idproduct` = '".$pid."' GROUP BY `category`", $this->connection);
		while ($category = mysql_fetch_array($cat_data)){
			$feed_data=mysql_query("SELECT * FROM feedback WHERE category ='".$category[0]."' AND idproduct='".$pid."'", $this->connection);
			while($feed=mysql_fetch_array($feed_data)){
				$feedback[$category[0]]['id'] = $feed['id'];
				$feedback[$category[0]]['comment']=$feed['comment'];
				$feedback[$category[0]]['type']=$feed['type'];
				$feedback[$category[0]]['thumb']=$feed['thumb'];
			}
		}
		return $feedback;
	}
	//Memcached
	
    function addAnswers ($qid,$pid,$uid,$ans){
    mysql_query("INSERT INTO `answers` (`qid`,`pid`,`uid`,`answer`,`date`) VALUES ('$qid','$pid','$uid','$ans', now())", $this->connection);
   }
    function addFeedback($category,$feed,$type,$id){
	  $category = mysql_real_escape_string($category);
	  $good = mysql_real_escape_string($good);
	  $bad = mysql_real_escape_string($bad);
	  $id = mysql_real_escape_string($id);
	  $data=mysql_query("select * from product where `idproduct`='$id'", $this->connection);
	  $data=mysql_fetch_array($data);
	  $name=$data['name'];
	  $q2= "Insert into notifications (`uid`,`username`,`text`,`idproduct`,`date`) values ('".$_SESSION['uid']."','".$_SESSION['username']."','added feedback','$id',now());";
	  mysql_query($q2, $this->connection);
	  mysql_query("INSERT INTO feedback (`id`,`category`,`idproduct`,`comment`,`thumb`, `type`,`date`, `uid`) VALUES (NULL,'".$category."','".$id."','".$feed."', 1,'".$type."',now(), '".$_SESSION['uid']."')", $this->connection);
   }
   
	function addNotification($uid, $un, $que, $pid){
		$uid = mysql_real_escape_string($uid);
		$pid = mysql_real_escape_string($pid);
		$que = mysql_real_escape_string($que);
		$un = mysql_real_escape_string($un);
		$que=("Insert into notifications (`uid`,`username`,`text`,`idproduct`,`date`) values ('".$uid."','".$un."','added a question \"".$que."\" for ','".$pid."',now())");
		mysql_query($que, $this->connection);
	}
   
	function addQuestion($pid, $uid, $que){
		$uid = mysql_real_escape_string($uid);
		$pid = mysql_real_escape_string($pid);
		$que = mysql_real_escape_string($que);
		$que = ("INSERT INTO `questions` (`idproduct`,`uid`,`question`,`date`) VALUES ('".$pid."','".$uid."','".$que."', now())");
		mysql_query($que, $this->connection);
	}
 
   function addActivity($uid, $pid, $type, $comment , $pname){
   $uid = mysql_real_escape_string($uid);
   $pid = mysql_real_escape_string($pid);
   $type = mysql_real_escape_string($type);
   $comment = mysql_real_escape_string($comment);
   $pname = mysql_real_escape_string($pname);
   $q = "INSERT INTO activity  (`uid` ,`pid` ,`type`, `comment`,`pname`,`date`) VALUES ( '".$uid."', '".$pid."', '".$type."', '".$comment."', '".$pname."' , now())";
   mysql_query($q, $this->connection);
   }
   
   function addProduct($name, $tags,$comment,$img){
	  $name = str_replace("-", "", mysql_real_escape_string($name));
	  $tags = mysql_real_escape_string($tags);
	  $comment = mysql_real_escape_string($comment);
      $q = "INSERT INTO product  (`idproduct` ,`name` ,`tags`, `comment`,`photo`,`userID`,`date`) VALUES ( NULL, '".$name."', '".$tags."', '".$comment."', '".$img."' , '".$_SESSION['uid']."',now())";
      mysql_query($q, $this->connection);
   }
   function getUID($u){
		 $u = mysql_real_escape_string($u);
		//$e=$_SESSION['email'];
		$q="SELECT * from users where username='$u'";
		$data=mysql_query($q,$this->connection);
		$data=mysql_fetch_array($data);
		return $data['uid'];
   }
   function getPIDofLike($idfeedback){
      $idfeedback = mysql_real_escape_string($idfeedback);
	  $q="Select * from feedback where id='$idfeedback';";
	  $data=mysql_query($q, $this->connection);
	  $data=mysql_fetch_array($data);
	  return $data['idproduct'];
   }
   function addLike($idfeedback){
      $idfeedback = mysql_real_escape_string($idfeedback);
	  $q="Select * from feedback where id='$idfeedback';";
	  $data=mysql_query($q, $this->connection);
	  $data=mysql_fetch_array($data);
	  $idproduct=$data['idproduct'];
	  $proddata=mysql_query("select * from product where `idproduct`='".$idproduct."'", $this->connection);
	  $prodinfo=mysql_fetch_array($proddata);
	  $name=$prodinfo['name'];
	  $query="SELECT * from rating WHERE `idfeedback`=".$idfeedback." AND `uid`='".$_SESSION['uid']."'";
	  $data=mysql_query($query, $this->connection);
	  if (mysql_num_rows($data)==0){
	  $data_user=mysql_query("select * from users where `uid`='".$_SESSION['uid']."'", $this->connection);
	  $info_user=mysql_fetch_array($data_user);
	  $q= "Insert into notifications (`uid`,`username`,`text`,`idproduct`,`date`) values ('".$info_user['uid']."','".$info_user['username']."',' rated','$idproduct',now());";
	  mysql_query($q, $this->connection);
      $q = "UPDATE feedback SET `thumb`=`thumb`+1 WHERE `id`=".$idfeedback."";
	  $q2 = "INSERT INTO rating  (`id` ,`idfeedback` ,`uid`) VALUES ( NULL, '".$idfeedback."', '".$_SESSION['uid']."')";
      mysql_query($q, $this->connection);
	  mysql_query($q2, $this->connection);
	  }
   }
   
   /**
    * getUserInfo - Returns the result array from a mysql
    * query asking for all information stored regarding
    * the given username. If query fails, NULL is returned.
    */
	
	function getForgotPassCredentials($email, $que, $ans){
		$email = mysql_real_escape_string($email);
		
		$que = mysql_real_escape_string($que);
		$ans = mysql_real_escape_string($ans);
		$q = "SELECT password FROM users WHERE `email`='".$email."' AND `que`='".$que."' AND `ans`='".$ans."' " ;
		$pword = (mysql_query($q, $this->connection));
		
		if(mysql_num_rows($pword) == 1)
			{
			$subject="Password Recovery";
			$pword = mysql_fetch_array ($pword);
			$message="Your password is: ".$pword['password'];
			$from = "do-not-reply@codemyworld.com"; 
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			$headers  .= "From: $from\r\n"; 
			
			mail($email, $subject, $message, $headers);  
			
			Redirect('forgotPass.php?e=1');
			}
		else {
		Redirect('forgotPass.php?e=0');
		}
		
	  
	}
	
	function getUserInfo($id){
		$query=$this->query("SELECT * FROM users WHERE `uid`='".$id."'");
		return mysql_fetch_array($query);
    }
	/*
   function getUserInfo($email){
	  $email = mysql_real_escape_string($email);
      $q = "SELECT * FROM users WHERE email = '$email'";
      $result = mysql_query($q, $this->connection);
      
      if(!$result || (mysql_num_rows($result) < 1)){
         return NULL;
      }
     
      $dbarray = mysql_fetch_array($result);
      return $dbarray;
   }*/
   
   /**
    * query - Performs the given query on the database and
    * returns the result, which may be false, true or a
    * resource identifier.
    */
   function query($query){
			return mysql_query($query, $this->connection);
   }
   function addPoints($uid,$pid,$act,$points=1){
	  $uid = mysql_real_escape_string($uid);
	  $pid = mysql_real_escape_string($pid);
	  $act = mysql_real_escape_string($act);
	  $query="insert into points(`uid`,`pid`,`action`,`points`) VALUES('$uid','$pid','$act','$points');";
      return mysql_query($query, $this->connection);
   }
   function getExperts($tag){
		$tag = mysql_real_escape_string($tag);
		$data=mysql_query("select idproduct from product where tags like '%".$tag."%';", $this->connection);
		$s="";
		while ($p=mysql_fetch_array($data)){
			$s=$s." `pid`='".$p['idproduct']."' OR ";
		}
		$s = $s." 1=2";
		return mysql_query("select uid,count(uid) as count,sum(points) as points from points where $s group by uid order by count desc",$this->connection);
   }
   function sendEmail($to,$subject,$message){
		/*
		$from = "do-not-reply@codemyworld.com"; 
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers  .= "From: $from\r\n"; 
		// now lets send the email. 
		mail($to, $subject, $message, $headers); 
		*/
		//Memcached
		// IF YOU ARE USING A NEW FROM EMAIL USE THIS SCRIPT TO VERIFY IT AND CLICK ON THE LINK YOU WILL RECIVE VIA EMAIL
		// print_r($ses->verifyEmailAddress(AWS_SAS_EMAIL));
		require_once('ses.php');
		$m = new SimpleEmailServiceMessage(AWS_SAS_ACCESS,AWS_SAS_SECRET);
		$m->addTo($to);
		$m->setFrom(AWS_SAS_EMAIL);
		$m->setSubject($subject);
		$m->setMessageFromString($message);
		//Memcached
   }
};
/**
* Basic redirect function
*/
function Redirect($url){
    echo "<script type='text/javascript'>window.location.href='".$url."';</script>";
	exit;
}

function addToSolr($data){
	$post_string = '<add><doc>';
	foreach ($data as $key => $value){
		$post_string = '<field name="$key">$value</field>';
	}
	$post_string = ' </doc></add>';
	$header = array("Content-type:text/xml; charset=utf-8");

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, SOLR_UPDATE_URL);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

	$data = curl_exec($ch);

	if (curl_errno($ch)) {
	   //print "curl_error:" . curl_error($ch);
	} else {
	   curl_close($ch);
	   //print "curl exited okay\n";
	   // echo "Data returned...\n";
	   //echo "------------------------------------\n";
	   //echo $data;
	   //echo "------------------------------------\n";
	}
}

function curPageURL() {
	$pageURL = 'http';
	if(isset($_SERVER["HTTPS"]))
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}
return $pageURL;
}

/* Create database connection */
$database = new MySQLDB;

?>
