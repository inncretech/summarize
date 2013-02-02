<form id="member-main-form" method="post" enctype="multipart/form-data" action='backend/ajax.post/image_uploader.php?member=true' style='margin-top:30px;margin-bottom: 5px;'>
	<div class="thumbnail" style="background:white;width:250px;min-height:150px;margin: 55px 0 5px 0px;">
	  <label style="width: 100%;height: 100%;margin:0px;">
		<label class="image-holder" style="margin:0px;">
			<img src="images/upload/member/<?=$visited_member_data['image']['full_image_url'];?>" id="image-preview" data-src="holder.js/300x200" alt="300x200">
		</label>
		<div id='preview'></div>
					
	  </label>
	</div>
</form>