
var register = new function(object) {
	var parent = this;
	this.listen = function (object) {
		$(object+" input").each(function(){
			$(this).change(function(){
				
				if ($(this).val()==''){
					$(this).attr("ready","false");
					if ((this.id == "email")||(this.id == "login")){
						$(this).parent().find("img").show();
						$(this).parent().find("img").attr("src",site_root+"/images/general-delete-icon.png");
					}
				}else{
					if ((this.id == "email")||(this.id == "login")){
							var item = this;
							if (item.id == "email"){
								var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
								if (regex.test($(item).val())){
									$.post(site_root+"/backend/ajax.get/member_check.php",{key:this.id ,value: $(this).val()},function(data){
										if (data=="1"){
											$(item).parent().find("img").show();
											$(item).parent().find("img").attr("src",site_root+"/images/general-delete-icon.png");
											$(item).attr("ready","false");
										}else{					
											$(item).parent().find("img").show();
											$(item).parent().find("img").attr("src",site_root+"/images/symbol-check-icon.png");
											$(item).attr("ready","true");
										}
									});
									
								}else{
									$(item).parent().find("img").show();
									$(item).parent().find("img").attr("src",site_root+"/images/general-delete-icon.png");
									$(item).attr("ready","false");
								}
							}else{
								$.post(site_root+"/backend/ajax.get/member_check.php",{key:this.id ,value: $(this).val()},function(data){
									if (data=="1"){
										$(item).parent().find("img").show();
										$(item).parent().find("img").attr("src",site_root+"/images/general-delete-icon.png");
										$(item).attr("ready","false");
									}else{					
										$(item).parent().find("img").show();
										$(item).parent().find("img").attr("src",site_root+"/images/symbol-check-icon.png");
										$(item).attr("ready","true");
									}
								});
							}
					}else if ((this.id != "email")&&(this.id != "login")){
						$(this).attr("ready","true");
						if ((this.id == "repassword")||(this.id == "regpassword")){
							
							if (($("#repassword").val()==$("#regpassword").val())&&($("#repassword").val().length > 5)) {
								$("#repassword").attr("ready","true"); 
								$("#regpassword").attr("ready","true");
								$(this).parent().find("img").show();
								$(this).parent().find("img").attr("src",site_root+"/images/symbol-check-icon.png");
							}else{
								$("#repassword").attr("ready","false"); 
								$("#regpassword").attr("ready","false");
								$(this).parent().find("img").show();
								$(this).parent().find("img").attr("src",site_root+"/images/general-delete-icon.png");
							}
						}
					}
					
				}
				
			});
		});
	};
	this.checkInput = function(object){
		$(object+" input").each(function(){
			if ($(this).val()==''){
				$(this).attr("ready","false");
				if ((this.id == "email")||(this.id == "login")){
					$(this).parent().find("img").show();
					$(this).parent().find("img").attr("src",site_root+"/images/general-delete-icon.png");
				}
			}else{
				if ((this.id == "email")||(this.id == "login")){
						var item = this;
						if (item.id == "email"){
							var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
							if (regex.test($(item).val())){
								$.post(site_root+"/backend/ajax.get/member_check.php",{key:this.id ,value: $(this).val()},function(data){
									if (data=="1"){
										$(item).parent().find("img").show();
										$(item).parent().find("img").attr("src",site_root+"/images/general-delete-icon.png");
										$(item).attr("ready","false");
									}else{					
										$(item).parent().find("img").show();
										$(item).parent().find("img").attr("src",site_root+"/images/symbol-check-icon.png");
										$(item).attr("ready","true");
									}
								});
								
							}else{
								$(item).parent().find("img").show();
								$(item).parent().find("img").attr("src",site_root+"/images/general-delete-icon.png");
								$(item).attr("ready","false");
							}
						}else{
							$.post(site_root+"/backend/ajax.get/member_check.php",{key:this.id ,value: $(this).val()},function(data){
								if (data=="1"){
									$(item).parent().find("img").show();
									$(item).parent().find("img").attr("src",site_root+"/images/general-delete-icon.png");
									$(item).attr("ready","false");
								}else{					
									$(item).parent().find("img").show();
									$(item).parent().find("img").attr("src",site_root+"/images/symbol-check-icon.png");
									$(item).attr("ready","true");
								}
							});
						}
				}else if ((this.id != "email")&&(this.id != "login")){
					$(this).attr("ready","true");
					if ((this.id == "repassword")||(this.id == "regpassword")){
						
						if (($("#repassword").val()==$("#regpassword").val())&&($("#repassword").val().length > 5)) {
							$("#repassword").attr("ready","true"); 
							$("#regpassword").attr("ready","true");
							$(this).parent().find("img").show();
							$(this).parent().find("img").attr("src",site_root+"/images/symbol-check-icon.png");
						}else{
							$("#repassword").attr("ready","false"); 
							$("#regpassword").attr("ready","false");
							$(this).parent().find("img").show();
							$(this).parent().find("img").attr("src",site_root+"/images/general-delete-icon.png");
						}
					}
				}
				
			}
		});
	}
	this.validateCaptcha = function()
	{
		/*challengeField = Recaptcha.get_challenge();
		responseField = Recaptcha.get_response();
		var html = $.ajax({
			type: "POST",
			url: site_root+"/backend/reCaptcha/validateform.php",
			data: "form=signup&recaptcha_challenge_field=" + challengeField + "&recaptcha_response_field=" + responseField,
			async: false
			}).responseText;
			
		if(html == "success") {
			return true;
		} else {
			return false;
		}*/
		return true;
	}
	this.check = function (object) {
		var ok =true;

		$(object+" input").each(function(){
			//alert($(this).attr("ready")+" "+$(this).attr("id"));
			if ($(this).attr("ready") != "true") ok = false;
			//alert($(this).attr("id")+" " + ok);
		});
		
		//alert(ok);
		
		return ok;
	};
	this.trigger = function (trigger,form) {
		$(trigger).click(function(){
			
			if (parent.check(form)) $(form).submit(); else $("#register-modal-error").text(" - please enter all data");
		});
		
	}
}

//Initiate
register.listen("#register-form");
register.trigger("#register-btn","#register-form");
//$('#registerModal').modal({
//  show: true
//});
/*
Recaptcha.create("6Lf2BtwSAAAAAMU0fFe4RVbM7DoI9I--P2cgPZ4b",
    "captcha_div",
    {
      theme: "red",
      callback: Recaptcha.focus_response_field
    }
  );
*/
