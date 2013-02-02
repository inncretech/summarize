<form id="member-main-form" style="float:left;margin-right: 40px;margin-bottom:0px" method="post" enctype="multipart/form-data" action='backend/ajax.post/image_uploader.php?member=true' >
	<div class="thumbnail" style="background:white;width:200px;min-height:150px;">
	  <label style="width: 100%;height: 100%;margin:0px;">
		<label class="image-holder" style="margin:0px;">
			<img src="images/upload/member/<?=$visited_member_data['image']['full_image_url'];?>" id="image-preview" data-src="holder.js/300x200" alt="300x200">
		</label>
		<div id='preview'></div>
					
	  </label>
	</div>
</form>