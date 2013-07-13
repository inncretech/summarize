<?php
include 'library/ses.php';

class Ses
{
	var $connection;

	/* Class constructor */
	function Ses()
	{
		$this->connection = new SimpleEmailService(AWS_SAS_ACCESS,AWS_SAS_SECRET);
	}
	
	function sendMail($to,$subject,$message){
		$m	= new SimpleEmailServiceMessage();
		$m->addTo($to);
		$m->setFrom(AWS_SAS_EMAIL);
		$m->setSubject($subject);
		$m->setMessageFromString(null,$message);
		$result = $this->connection->sendEmail($m);
	}
}
$ses = new Ses();
?>


