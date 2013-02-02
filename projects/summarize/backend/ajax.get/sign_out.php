<?php
require_once "../session.class.php";
$session = new Session();
if ($session->check()) $session->destroy();
echo "true";
?>