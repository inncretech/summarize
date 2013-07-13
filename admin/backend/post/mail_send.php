<?php
include "../database/database.class.php";
include "../session.class.php";
include "../email/ses.class.php";
include "../global.function.php";

$get = $_GET;

$responce 	= Array();
$request 	= json_decode(file_get_contents('php://input'));

switch ($get['case']) {
    case '0':
		
		$member = $db->member->getAll();
		foreach ($member as $item){
			$to		 = $item['email'];
			$subject = $request->subject;
			$message = $request->message;
			$ses->sendMail($to,$subject,$message);
		}
		break;
    case '1':

		$member  = $db->member->get($get['member_id']);
	    $to		 = $member['email'];
		$subject = $request->subject;
		$message = $request->message;
		$ses->sendMail($to,$subject,$message);
		break;
}
?>