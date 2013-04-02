<?php
include "../constants.php";
include "../session.class.php";
include "../global.functions.php";

$database  			= new Database();
$session			= new Session();
$member_data 		= $session->get();			
$data 				= $database->escape($_POST);

$survey_id		 	= $database->survey->add($data['title'],$member_data['member_id']);
$info = $data;
foreach ($data as $key=>$value){
	$key = explode("-", $key);
	
	if (($key[0]=="question")&&($key[1]!="type")){
		$question_id = $database->survey_question->add($survey_id,$value,$info['question-type-'.$key[1]],$member_data['member_id']);
		foreach ($info as $index=>$item){
			$index = explode("-", $index);
			if (($index[0]=='answer')&&($index[1]==$key[1])){
				$database->survey_answer->add($question_id,$survey_id,$item,$member_data['member_id']);
			}
			if (($index[0]=='textarea')&&($index[2]==$key[1])){
				for ($i = 1; $i <= intval($item); $i++)
				$database->survey_answer->add($question_id,$survey_id,null,$member_data['member_id']);
			}
		}
	}
}
Redirect(SITE_ROOT."/survey.php?id=".$survey_id)
?>