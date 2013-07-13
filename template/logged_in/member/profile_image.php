<form id="member-main-form" style="float:left;margin-right: 40px;margin-bottom:0px" method="post" enctype="multipart/form-data" action='backend/ajax.post/image_uploader.php?member=true' >
	<div class="thumbnail" style="background:white;width:200px;margin: 20px 0 0 0px;">
	  <label style="margin:0px;">
		<label class="image-holder" style="margin:0px;">
			<img src="<?='http://'.(S3_BUCKET).'.s3.amazonaws.com/m_'.$member_data['public_id']."_normal.jpg";?>" id="image-preview" data-src="holder.js/300x200" alt="300x200" style="max-width:100%;">
		</label>
		<div id='preview'></div>
					
	  </label>
	</div>
	<label class="btn btn-block btn-info" style="text-align:center;">
		<input type="file" style="display:none;" name="photo" id="member-photo">
		<span >Upload Image<span>
	</label>
	<input type="hidden" name="member" value="true">
	
</form>