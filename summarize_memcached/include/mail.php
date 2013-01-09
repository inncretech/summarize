<?php
$to = $_POST['to']; 
$from = "noreplay@summarize.com"; 
$subject = "Summarize Invitation"; 
$message = "<p>Your friend ".$_POST['name']." invites you to Summarize</p>";
//end of message 
// To send the HTML mail we need to set the Content-type header. 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$headers  .= "From: $from\r\n"; 
// now lets send the email. 
mail($to, $subject, $message, $headers); 
?>