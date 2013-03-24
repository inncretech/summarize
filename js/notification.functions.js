var notification = new function() {
	var parent = this;

	this.send = function (comment,type) {
		
		$.post(site_root+"/backend/ajax.post/send_notification.php",{comment:comment,type:type,product_id:product_id},function(data){
			
			parent.refresh(".notification-box");
		});
	}
	
	this.refresh = function (div) {
		$.post(site_root+"/backend/ajax.get/get_notifications_count.php",function(data){$(div).text(data);});
	}
	
	this.close = function (target) {
		var id = $(target).attr("data");
		$.post(site_root+"/backend/ajax.post/hide_notification.php",{id:id},function(data){parent.refresh(".notification-box");});
	}
	
}

notification.refresh(".notification-box");
