var message = new function() {
	var parent = this;

	this.refreshSent = function (div) {
		$.post(site_root+"/backend/ajax.get/sent_messages.php",function(data){

			render.messageSent(data,div);
		});
	}
	
	this.refreshInbox = function (div) {
		$.post(site_root+"/backend/ajax.get/received_messages.php",function(data){
			render.messageInbox(data,div);
		});
	}
	
	this.listen = function (trigger) {
		$(trigger).click(function(){
			$.post(site_root+"/backend/ajax.post/send_message.php",{subject: $("#subject").val(),body:$("#body").val(),to_member_name:$("#to_member_name").val()},function(data){
				$("#message-status").append("Message succesfull sent");
				parent.refreshInbox("#inbox");
				parent.refreshSent("#sent");
			});
		});
	}
	
}
message.listen("#send-message-btn");
message.refreshInbox("#inbox");
message.refreshSent("#sent");