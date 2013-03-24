
var application = new function(object) {
	var parent = this;
	this.create = function (object) {
		$("#create-application-btn").text("Loading...");

		$.post(site_root+"/backend/ajax.post/add_application.php",{site_name: $("#site-name").val(), site_url: $("#site-domain").val()},function(data){
		
			$("#app-form").html("<span>Application Secret Key</span>: "+data);
		});
	};
	
}

