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
$subject 	= "SummarizIt.com";
$message 	= file_get_contents(SITE_ROOT.'/template/invitation.html');

foreach ($to as $email) $result		= $ses->send($email,$subject,$message);

/*
$to = $_POST['fb_id'];
echo $to;
$params = array(
                'message'       =>  "Hurray! This works :)",
                'name'          =>  "This is my title",
                'caption'       =>  "My Caption",
                'description'   =>  "Some Description...",
                'link'          =>  "http://stackoverflow.com",
                'picture'       =>  "http://i.imgur.com/VUBz8.png",
            );

            $post = $facebook->connection->api("/100001671820227/feed","POST",$params);
*/

?>


