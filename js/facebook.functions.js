var facebook = new function(){
	this.post = function(url,title){
		$.post("backend/ajax.post/facebook.post.php",{url:url,title:title},function(data){alert("\""+title+"\" has been posted to your facebook page.");});
	}
}
