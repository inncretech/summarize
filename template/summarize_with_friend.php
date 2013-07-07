
<!-- Modal -->
<div id="summarizeFriend" style="top:1%;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
      <h2>Summarize With Friends
      </h2>
	  <p>Get your friends to Summarize with you about <?=$product_data['title']?>.</p>
    </div>
  
	<div class="modal-body grey" style="text-align:left;max-height:500px;">
	<div class="alert alert-success" id="invitation-msg" style="margin-bottom: 5px;display:none;">
		<strong>Yeey!</strong> Invitation Sent.
	</div>

	<div class="control-group">
    
    
		<?php if ($facebook->check){ ?>
		<p>
		<button class="btn btn-primary" style="width:200px;">
			<label class="checkbox">
				<input type="checkbox" id="fb-post"> Post On Facebook
			</label>
		</button>
		</p>
		<?php } ?>
	
	</div>

	<input type="text"  id="fb-friend-id" style="margin:0px;width: 100%;display:none;" >
	<input type="text"  id="invitation-email"  style="margin:0px;margin-bottom:5px;width: 97%;;" placeholder="Enter e-mail addresses separated by comma">
	<textarea id="invitation-text"  style="width: 97%;" placeholder="Invitation Message"></textarea>
	<p></p>
	<button type="submit" class="btn btn-primary pull-left" onclick="sendInvitation();return false;" id="sign-in-btn">Submit</button>
	
	</div>
</div>
<script type="text/javascript" src="<?=SITE_ROOT;?>/js/ckeditor/ckeditor.js"></script>

<script>
CKEDITOR.config.toolbar_MA=[ ['Cut','Copy','Paste','-','Undo','Redo','-','Link','Unlink','-','Bold','Italic','Underline','-',['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],'-','NumberedList','BulletedList','-','Outdent','Indent'] ];
var ck_editor = CKEDITOR.replace( 'invitation-text', {  height: '200px',resize_enabled : false    });
function sendInvitation(){
	$('#invitation-msg').hide();
	var fb_check = 'false';
	if ($('#fb-post').is(':checked')) fb_check='true';
	$.post(site_root+"/backend/ajax.post/send_invitation.php",{url:window.location.href,title:'<?=$product_data['title']?>',fb_post:fb_check,email:$('#invitation-email').val(),msg:ck_editor.getData()},function(data){
		console.log(data);
		$('#invitation-msg').show();
	});
}


</script>