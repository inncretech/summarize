var survey = new function(){
	var parent = this;
	var questionCount = 0;
	var answerCount = 0;
	this.addQuestion = function(value){
		
		var code  = '<div class="unstyled well" id="question-container-'+questionCount+'">';
			code += '<input class="span7" style="width: 75%;" type="text" placeholder="Question" id="question-'+questionCount+'" name="question-'+questionCount+'">';
			code += '<select onchange="survey.checkQType('+questionCount+',this)" id="question-type-'+questionCount+'" name="question-type-'+questionCount+'" style="margin-left:5px;width: 110px;">';
			code += '<option value="checkbox">Checkbox</option>';
			code += '<option value="radio">Radio</option>';
			code += '<option value="textarea">Textbox</option>';
			code += '</select><img onclick=\'document.getElementById("question-container-'+questionCount+'").parentNode.removeChild(document.getElementById("question-container-'+questionCount+'"));\' style="float:right;cursor:pointer" src="'+site_root+'/images/general-delete-icon.png">';
			code += '<div id="answer-container-'+questionCount+'">';
			code += '</div>';
			code += '<button id="add-answer-btn-'+questionCount+'" onclick="survey.addAnswer('+questionCount+');return false;" class="btn btn-warning" style="margin-bottom:5px;">Add Answer</button>';
			code += '</div>';
		$("#survey-question").append(code);
		questionCount++;
	}
	this.addAnswer = function(value){
		$("#answer-container-"+value).append("<div id='ans-parent-"+value+"'><input type='text' placeholder='Answer' class='span8' style='width:92%' id='answer-"+value+"-"+answerCount+"' name='answer-"+value+"-"+answerCount+"'><img onclick=\"document.getElementById('ans-parent-"+value+"').parentNode.removeChild(document.getElementById('ans-parent-"+value+"'));\" style='float:right;cursor:pointer' src='"+site_root+"/images/general-delete-icon.png'></div>");
		answerCount++;
	}
	this.remove = function(key,id){
		$("#survey-row-"+key).remove();
		$.post(site_root+'/backend/ajax.post/remove_survey.php',{survey_id:id},function(data){
			console.log(data);
		});
	}
	
	this.checkQType = function(value,item){
		if ($(item).val()=="textarea"){
			$("#answer-container-"+value).html('');
			$("#add-answer-btn-"+value).remove();
			var code  = '<select id="textarea-value-'+value+'" name="textarea-value-'+value+'" style="margin-bottom:5px;">';
			    code += '<option value="1">1</option>';
				code += '<option value="2">2</option>';
				code += '<option value="3">3</option>';
				code += '<option value="4">4</option>';
				code += '<option value="5">5</option>';
				
				code += '</select>';
			$("#question-container-"+value).append(code);
		}else{
			$("#add-answer-btn-"+value).remove();
			$("#textarea-value-"+value).remove();
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
		else{
			$("#survey-error").show();
		}
	}
	
	this.checkCompletedForm = function(){
		var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if (($("#survey-email").val()!="")&&(regex.test($("#survey-email").val()))&&(!member_login)) $("#taked-survey").submit();
		if ((($("#survey-email").val()=="")||(!regex.test($("#survey-email").val())))&&(!member_login)) alert("Please fill up the email address.");
		if (member_login) $("#taked-survey").submit();
	}
}