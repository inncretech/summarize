(function(){
    var logout = new function() {
		var parent = this;

		this.listen = function (trigger) {
			$(trigger).click(function(){
				$.post("backend/ajax.get/sign_out.php",function(data){
						if (data == "true")	document.location.reload(true);
				});
			});
		}
		
	}
	logout.listen("#logout-button");
})();
