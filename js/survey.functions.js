var survey = new function(){
	var parent = this;
	var questionCount = 0;
	var answerCount = 0;
	this.addQuestion = function(value){
		
		var code  = '<div class="unstyled well" id="question-container-'+questionCount+'">';
			code += '<input class="span7" type="text" placeholder="Question" id="question-'+questionCount+'" name="question-'+questionCount+'">';
			code += '<select onchange="survey.checkQType('+questionCount+',this)" id="question-type-'+questionCount+'" name="question-type-'+questionCount+'" style="margin-left:5px;width: 110px;">';
			code += '<option value="checkbox">Checkbox</option>';
			code += '<option value="radio">Radio</option>';
			code += '<option value="textarea">Textbox</option>';
			code += '</select>';
			code += '<div id="answer-container-'+questionCount+'">';
			code += '</div>';
			code += '<button id="add-answer-btn-'+questionCount+'" onclick="survey.addAnswer('+questionCount+');return false;" class="btn btn-warning" style="margin-bottom:5px;">Add Answer</button>';
			code += '</div>';
		$("#survey-question").append(code);
		questionCount++;
	}
	this.addAnswer = function(value){
		$("#answer-container-"+value).append("<input type='text' placeholder='Answer' class='span8' id='answer-"+value+"-"+answerCount+"' name='answer-"+value+"-"+answerCount+"'><br>");
		answerCount++;
	}
	this.checkQType = function(value,item){
		if ($(item).val()=="textbox"){
			$("#answer-container-"+value).html('');
			$("#add-answer-btn-"+value).remove();
		}else{
			$("#add-answer-btn-"+value).remove();
			var code = '<button id="add-answer-btn-'+value+'" onclick="survey.addAnswer('+value+');return false;" class="btn btn-warning" style="margin-bottom:5px;">Add Answer</button>';
			$("#question-container-"+value).append(code);
		}
	}
	
	this.checkForm = function(){
		var ok = true;
		$("#survey-create-form input").each(function() {
		   if($(this).val() === "") ok=false;
		});
		if (ok) $("#survey-create-form").submit();
	}
	
	this.checkCompletedForm = function(){
		var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if (($("#survey-email").val()!="")&&(regex.test($("#survey-email").val()))&&(!member_login)) $("#taked-survey").submit();
		if (member_login) $("#taked-survey").submit();
	}
}