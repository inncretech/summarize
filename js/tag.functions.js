var tag = new function() {
		var parent = this;
		
		this.save = function (tag_name,product_id) {
				
				$.post(site_root+"/backend/ajax.post/add_tag.php",{tag_name:tag_name,product_id:product_id},function(data){
					notification.send("Added "+"<span class='tag'>"+tag_name+"</span>","Tag");
				});
			
		
		}
		this.remove = function (tag_name,product_id) {
					
				$.post(site_root+"/backend/ajax.post/remove_tag.php",{tag_name:tag_name,product_id:product_id},function(data){
					
					notification.send("Removed "+"<span class='tag'>"+tag_name+"</span>","Tag");
				});
			
		}
		
}

