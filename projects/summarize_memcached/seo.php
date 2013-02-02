<?php
require_once "include/database.php";
$aux = explode("/",curPageURL());
$id=array_pop($aux);
$id=explode("-",$id);
$name = implode(" ", $id);
$data=$database->query("select * from product where name='".$name."' ");
$data=mysql_fetch_array($data);
$id=$data['idproduct'];
include "result.php";
?>
 