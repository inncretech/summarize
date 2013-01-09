<?php
session_start();
$e=$_SESSION['uid'];
include "database.php";
if(isset($e)){
	$e=$_SESSION['uid'];
	$r=$_GET['r'];
	$add=$_GET['a'];
	$id=$_GET['id'];
	$n=$_GET['n'];
	if(isset($_GET['r'])){
		$database->query("DELETE FROM compare where uid='$e' and idproduct='$r'");
	}
	if(isset($_GET['a'])){
		if ($_GET['a']==-1){
			$n=explode(",",$n);
			$n=$n[0];
			$data=$database->query("select * from compare where `uid`='$e' and `name`='$n'");
			
			if (mysql_num_rows($data)<1) {
				$data=$database->query("select * from product where `name`='$n'");
				if (mysql_num_rows($data)>0){
				$data=mysql_fetch_array($data);
				$database->query("insert into `compare` (`idproduct`,`name`,`uid`) values('".$data['idproduct']."','$n','$e')");
				}}

		} else {
			$data=$database->query("select * from compare where `uid`='$e' and `idproduct`='$add'");
			if (mysql_num_rows($data)<1) $database->query("insert into `compare` (`idproduct`,`name`,`uid`) values('$add','$n','$e')");
		}
	}

	$data=$database->query("Select * from compare where uid='$e'");
	while ($info=mysql_fetch_array($data)){
			echo "<div id='compare-container'><a id='compare-item' href='result.php?id=".$info['idproduct']."'>".$info['name']."</a>  <a id='delete-compare' href='javascript:void(0);' onclick='remove_from_compare(\"".$info['idproduct']."\")'>x</a></div>";
	}
}
?>
