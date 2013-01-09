<?php
require_once 'simple_html_dom.php';

function save_data($data){
		$text = "";
		foreach ($data as $url){
			$html = file_get_html($url);
			foreach($html->find('p[class=reviewTextBody]') as $element){
				$text .= "//Review\n";
				$text .= trim(strip_tags($element->plaintext))."\n\n\n";
			}
		}
		$name = "upload/".time().".txt";
		$file = fopen($name, 'w') or die("can't open file");
		fwrite($file, $text);
		fclose($file);
		echo $name;
}

if (isset($_POST['data'])){
	$data = explode(",",$_POST['data']);
	save_data($data);
}
?>