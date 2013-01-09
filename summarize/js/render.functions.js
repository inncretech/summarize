(function(){
    var render = new function() {
		//this.type = "class";
		this.SecretQuestions = function (object) {
			var code = "<select class='select-xlarge' name='ref_secret_question1_id' id='ref_secret_question1_id'>";
			$.post("backend/ajax.get/register_details.php", function(data) {
			obj = JSON.parse(data);
				$.each(obj, function(key, val) {
					code += '<option name="'+val.id+'" id="'+val.id+'">'+val.secret_question+'</option>';
				});
			code += "</select>";
			$(object).html(code);
			});
		};
	}
	
	//Initiate
	render.SecretQuestions("#secret-questions");
})();
