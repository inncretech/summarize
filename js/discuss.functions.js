var discuss = new function(){
	var parent = this;
	this.addQuestion = function(){
		if ($("#questionText").val()!=""){
			if (member_login){
				
				$.post(site_root+"/backend/ajax.post/add_question.php",{product_id:product_id,question_text:$("#questionText").val()},function(data){
					parent.refresh();
					notification.send($("#questionText").val(),"Question");
				});
			}
		}
	}
	this.refresh = function(){
		if(typeof product_id != 'undefined'){
			$.post(site_root+"/backend/ajax.get/get_discuss.php",{product_id:product_id},function(data){	
				render.discuss(data);
			});
		}
	}
	
	this.addAnswer = function(question_id){
		if (member_login){
			var answer_text = $("#answerInput"+question_id).val();
			if ($("#answerInput"+question_id).val()!=""){
				$.post(site_root+"/backend/ajax.post/add_answer.php",{product_id:product_id,answer_text:answer_text,question_id:question_id},function(data){
					notification.send(answer_text,"Answer");
					answer = JSON.parse(data);
					var code ='<div><span style="position: relative;padding-right: 10px;top: 10px;"><i style="cursor:pointer;" class="icon-chevron-up" onclick="discuss.rateAnswer(\''+answer.answers_id+'\',0);"></i><br><i style="cursor:pointer;" class="icon-chevron-down" onclick="discuss.rateAnswer(\''+answer.answers_id+'\',1);"></i></span><a href="'+site_root+'/member/'+answer.seo_title+'">'+answer.login+'</a>: <span id="answerText'+answer.answers_id+'">'+answer_text+'</span><span id="ansrating'+answer.answers_id+'" style="float:right;">'+answer.total_likes+'/'+answer.total_unlikes+'</span></div>';
					
					$("#answerAddForm"+question_id).append(code);
				});
			}
		}
	}
	
	this.rateAnswer = function(answer_id,type){
		if (member_login){
				$.post(site_root+"/backend/ajax.post/add_answer_rating.php",{product_id:product_id,answer_id:answer_id,type:type,answer_text:$('#answerText'+answer_id).text()},function(data){
					
					notification.send($('#answerText'+answer_id).text(),"Answer Rated");
					parent.refreshAnsRating(answer_id);
					
				});
		}
	}
	
	this.refreshAnsRating = function(answer_id){
		
		$.post(site_root+"/backend/ajax.get/get_answer_rating.php",{answer_id:answer_id},function(data){
			
			obj = JSON.parse(data);
			$("#ansrating"+answer_id).html(obj.total_likes+"/"+obj.total_unlikes);
		});

	}
	
	this.listenQuestion = function(trigger){
		$(trigger).click(function(){
			parent.addQuestion();
		});
	}
}
if(typeof product_id != 'undefined'){
	discuss.refresh();
	discuss.listenQuestion("#addQuestionBtn");
}