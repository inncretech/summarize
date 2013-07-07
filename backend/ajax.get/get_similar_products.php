<?php
require_once "../constants.php";
require_once "../session.class.php";
$database 		= new Database();
$session 		= new Session();

$data 								= $database->escape($_POST);

$base_tags		   					= $database->product_tag->get($data['product_id']);
$base_categories		   			= $database->product_feedback->getCategories($data['product_id']);
$value								= Array();
$products   = Array();

foreach ($base_tags as $item){
	$aux = $database->product_tag->getByTag($item);
	foreach ($aux as $val){
		if ($val!=$data['product_id']) $products[$val]+=1;
	}
}

foreach ($base_categories as $item){
	$aux = $database->product_feedback->getProductsByCategory($item);
	foreach ($aux as $val){
		if ($val!=$data['product_id']) $products[$val]+=1;
	}
}

$max = 0;
$value = Array();
foreach ($products as $key=>$item){
	if ($item>$max){
		$value[3] = $value[2];
		$value[2] = $value[1];
		$value[1] = $value[0];
		$value[0] = $key;
	}
}

$final = Array();
foreach ($value as $item){

	$aux = $database->product->get($item);
	array_push($final,$aux);
}

echo json_encode($final);
?>