var facebookAPP = new function(){
	var parent = this;
	/*this.post = function(url,title){
		$.post(site_root+"/backend/ajax.post/facebook.post.php",{url:url,title:title},function(data){
			
			alert("\""+title+"\" has been posted to your facebook page.");
		});
	}*/
	
	this.init = function (app_id,site_root){
		// Additional JS functions here
		window.fbAsyncInit = function() {
		FB.init({
		  appId      : app_id, // App ID
		  channelUrl : site_root, // Channel File
		  status     : true, // check login status
		  cookie     : true, // enable cookies to allow the server to access the session
		  xfbml      : true  // parse XFBML
		});

		// Additional init code here

		};

		// Load the SDK Asynchronously
		(function(d){
			 var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			 if (d.getElementById(id)) {return;}
			 js = d.createElement('script'); js.id = id; js.async = true;
			 js.src = "//connect.facebook.net/en_US/all.js";
			 ref.parentNode.insertBefore(js, ref);
		}(document));
	}
	
	this.jsPost = function(url,title){
		$('#social-loading').show();
		FB.api('/me/feed', 'post', { name: title, link:url }, function(response) {
		  if (!response || response.error) {
			console.log('Error occured');
		  } else {
			console.log('Post ID: ' + response.id);
			$('#social-loading').hide();
			$('#social-msg').show();
			$('#social-msg').text("Posted on your timeline!");
		  }
		});
	}
	
	
	this.login = function(url,title) {
		FB.getLoginStatus(function(response){
   
			FB.login(function(response) {
				if (response.authResponse) {
					parent.testAPI();// connected
					FB.getLoginStatus(function(response) {
					  if (response.status === 'connected') {
						parent.jsPost(url,title);
					  } else if (response.status === 'not_authorized') {
						console.log('Not authorized!');// not_authorized
					  } else {
						console.log('Not logged in!'); // not_logged_in
					  }
					 });
				} else {
					// cancelled
				}
			});
		 });
	}
	
	this.testAPI = function () {
		console.log('Welcome!  Fetching your information.... ');
		FB.api('/me', function(response) {
			console.log('Good to see you, ' + response.name + '.');
		});
	}

}
