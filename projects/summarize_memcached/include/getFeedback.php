<?php

include "database.php";
include "memcached.php";

$aux=0;
$ok=false;
$memcachedServers=explode(",",MEMCACHED_HOSTS);
	if (count($memcachedServers)>0){
		$memcached = new MemcachedCon($memcachedServers,MEMCACHED_PORT);
		$result = $memcached->connection->get('f-'.$_POST['n']."-".$_POST['pi']);
		
		if ($result!='') {
			echo json_encode($result);
			
		}else{$ok=true;}
	}else{$ok=true;}

if ($ok){
	$data=$database->query("SELECT * FROM feedback WHERE id='".$_POST['id']."'");
	$info=mysql_fetch_array($data);
	$fd=$database->query("SELECT * FROM feedback WHERE category ='".$info['category']."' AND idproduct='".$info['idproduct']."'");
	$feed = array();
	$aux = 0;
	while($fi=mysql_fetch_array($fd)){
		$feed[$aux]['id'] = $fi['id'];
		$feed[$aux]['comment']=$fi['comment'];
		$feed[$aux]['type']=$fi['type'];
		$feed[$aux]['thumb']=$fi['thumb'];
		$aux = $aux+1;
	}
	echo json_encode($feed);
}
?>