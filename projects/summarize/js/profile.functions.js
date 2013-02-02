
var profile = new function() {
	var parent = this;
	this.listen = function (form) {
		$(form+" input").each(function(){
			$(this).change(function(){
					if ($(this).val()==''){
						$(this).attr("ready","false");
						if ((this.id == "email")||(this.id == "login")){
							$(this).parent().find("img").show();
							$(this).parent().find("img").attr("src","images/general-delete-icon.png");
						}
					}else{
						if ((this.id == "email")||(this.id == "login")){
								var item = this;
								if (item.id == "email"){
									var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
									if (regex.test($(item).val())){
										$.post("backend/ajax.get/member_check.php",{key:this.id ,value: $(this).val()},function(data){
											if (data=="1"){
												$(item).parent().find("img").show();
												$(item).parent().find("img").attr("src","images/general-delete-icon.png");
												$(item).attr("ready","false");
											}else{					
												$(item).parent().find("img").show();
												$(item).parent().find("img").attr("src","images/symbol-check-icon.png");
												$(item).attr("ready","true");
											}
										});
										
									}else{
										$(item).parent().find("img").show();
										$(item).parent().find("img").attr("src","images/general-delete-icon.png");
										$(item).attr("ready","false");
									}
								}else{
									$.post("backend/ajax.get/member_check.php",{key:this.id ,value: $(this).val()},function(data){
										if (data=="1"){
											$(item).parent().find("img").show();
											$(item).parent().find("img").attr("src","images/general-delete-icon.png");
											$(item).attr("ready","false");
										}else{					
											$(item).parent().find("img").show();
											$(item).parent().find("img").attr("src","images/symbol-check-icon.png");
											$(item).attr("ready","true");
										}
									});
								}
						}else if ((this.id != "email")&&(this.id != "login")){
							$(this).attr("ready","true");
						}
					}
				});
		});
		
	}
	this.check = function (form) {
		    var ok =true;
			$(form+" input").each(function(){
				//alert($(this).attr("ready")+" "+$(this).attr("id"));
				if ($(this).attr("ready") != "true") ok = false;
			});
			//alert(ok);
			return ok;
		};
		
	this.trigger = function (trigger,form) {
		$(trigger).click(function(){
			if (parent.check(form)){
				
				$.post("backend/ajax.post/member_update.php",$(form).serialize(),function(data){
					
					$("#update-user-success").show();
					$("#update-user-error").hide();
				});
			}else{
				$("#update-user-error").show();
				$("#update-user-success").hide();
			}
		});
		
	}
	
}
profile.listen("#member-profile-page");
profile.trigger("#update-member-btn","#member-profile-page");

