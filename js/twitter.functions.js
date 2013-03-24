var twitterAPP = new function(){
	this.post = function(url,title){
		if (member_login){
			if (twitter){
				$('#social-loading').show();
				$.post(site_root+"/backend/ajax.post/twitter.post.php",{url:url,title:title},function(data){
					$('#social-loading').hide();
					$('#social-msg').show();
					$('#social-msg').text("Posted on your timeline!");
				});
			}else{
				$('#social-msg').show();
				$('#social-msg').text("Please logout and login with your Twitter Account!");
			}
		}else{
			$('#signInModal').modal('show');
		}
	}
}
