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
		if ($val!=$data['product_id']) $products[$val]['tag']+=1;
	}
}

foreach ($base_categories as $item){
	$aux = $database->product_feedback->getProductsByCategory($item);
	foreach ($aux as $val){
		if ($val!=$data['product_id']) $products[$val]['category']+=1;
	}
}
$final = Array();
$count = count($products);
for ($i = 0; $i <$count ; $i++) {
	
   $final[$i] = ($products[$i]['tag']+$products[$i]['category'])/2;
}

function cmp($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a > $b ? -1 : 1);
}

uasort($final, 'cmp');


$value = Array();
foreach ($final as $key=>$item){

	$aux = $database->product->get($key);
	array_push($value,$aux);
}
$value = array_filter($value);

$value = array_slice($value, 0, 4);
echo json_encode($value);
?>