<?php
echo "Start of page<br>";
include "../constants.php";
include "../email.system/aws.class/ses.php";
echo "Included constands and ses<br>";
$ses = new SimpleEmailService(AWS_SAS_ACCESS, AWS_SAS_SECRET);
print_r($ses);
echo "<br>";
echo "Created Class<br>";

print_r($ses->listVerifiedEmailAddresses());
echo "Printed list of verified emails<br>";

$FROM_ENCODE = 'summarizit@gmail.com';
$SUBSCRIBER_ENCODE = 'pietroiu.alexandru@gmail.com';
$DATE = gmdate('D, d M Y H:i:s e');
$HASH = hash_hmac('sha1', $DATE, $AWSPRI, true);
$KEYS = base64_encode($HASH);
$headers = array();
$headers[] = "Host: email.us-east-1.amazonaws.com";
$headers[] = "Content-Type: application/x-www-form-urlencoded";
$headers[] = "Date: ".$DATE;
  $auth = "AWS3-HTTPS AWSAccessKeyId=".AWS_SAS_ACCESS;
  $auth .= ",Algorithm=HmacSHA1,Signature=".AWS_SAS_SECRET;
$headers[] = "X-Amzn-Authorization: ".$auth;
$url = "https://email.us-east-1.amazonaws.com/";
$MAIL =  "Action=SendEmail&Source=".$FROM_ENCODE."&ReturnPath=&Destination.ToAddresses.member.1=".$SUBSCRIBER_ENCODE."&Message.Subject.Data=daaa&Message.Body.Html.Data=daaa";
$aws = curl_init();
curl_setopt($aws, CURLOPT_POSTFIELDS, $MAIL);
curl_setopt($aws, CURLOPT_HTTPHEADER, $headers);
curl_setopt($aws, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($aws, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($aws, CURLOPT_HEADER, false);
curl_setopt($aws, CURLOPT_URL, $url);
curl_setopt($aws, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($aws);
curl_close($aws);
print_r($output);
?>