<?php
include "../session.class.php";
include "../email.system/amazon.email.php";
print_r($_POST);
$session 		= new Session();
$database 		= new Database();
$facebook		= new Fb();
$member_data 	= $session->get();
$member_info    = $database->member_info->get($member_data['member_id']);

$ses 		= new  AmazonEmail();
$to			= explode(',',$_POST['email']);
$subject 	= "Summarize about ".$_POST['title'];
$message 	= file_get_contents(SITE_ROOT.'/template/invitation.html');
$message 	= str_replace("{#message#}",$_POST['msg'],$message);
foreach ($to as $email) $result		= $ses->send($email,$subject,"&nbsp;&nbsp;&nbsp;&nbsp;".$message);

if ($_POST['fb_post']=='true'){
	$photo 		= $facebook->connection->api('/me/feed/', 'POST',
											array(
											'link' => $_POST['url'],
											'name' => 'SummarizIt',
											'description'=>'Check the best review site on the web.',
											//'message'       => 'SummarizIt'
											)
	);
}
?>


