<?php
require_once('aws.class/ses.php');

class AmazonEmail
{
	var $connection;

	/* Class constructor */
	function AmazonEmail()
	{
		$this->connection = new SimpleEmailService(AWS_SAS_ACCESS,AWS_SAS_SECRET);
	}
	
	function send($to,$subject,$message){
		$m	= new SimpleEmailServiceMessage();
		$m->addTo($to);
		$m->setFrom(AWS_SAS_EMAIL);
		$m->setSubject($subject);
		$m->setMessageFromString(null,$message);
		$result = $this->connection->sendEmail($m);
	}
}
?>


