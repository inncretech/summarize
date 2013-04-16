
<!-- Modal -->
<div id="summarizeFriend" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
      <h2>Summarize With Friends
      </h2>
    </div>
  
	<div class="modal-body grey" style="overflow:hidden;">
	<div class="alert alert-success" id="invitation-msg" style="margin-bottom: 5px;display:none;">
		<strong>Yeey!</strong> Invitation Sent.
	</div>
	<div class="form-horizontal" id="register-text" style="text-align: center;margin-bottom:10px;">
		Get your friends to summarize with you by sending them an invitation.
	</div>
	<input type="text"  id="fb-friend-name" style="margin:0 0 5px 0;width: 95%;" placeholder="Facebook Friend">
	<input type="text"  id="fb-friend-id" style="margin:0px;width: 100%;display:none;" >
	<input type="text"  id="invitation-email" style="margin:0px;width: 82%;" placeholder="Email">
	<button type="submit" class="btn btn-primary" onclick="sendInvitation();return false;" id="sign-in-btn">Send</button>
	
	</div>
</div>

<script>
function sendInvitation(){
	$('#invitation-msg').hide();


	$.post(site_root+"/backend/ajax.post/send_invitation.php",{fb_id:$("#fb-friend-id").val(),email:$('#invitation-email').val()},function(data){
		console.log(data);
		$('#invitation-msg').show();
	});
}


</script>