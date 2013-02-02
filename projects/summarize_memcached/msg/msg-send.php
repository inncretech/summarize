
<div id='msg-container-send'>
<span id='title'>Send a message to <font color='#08C'><?=$username;?></font> :</span>
<div id='block'></div>
<textarea style=' resize:none;width:770px;height:100px;margin-top:5px;' id='message' placeholder='Message...'></textarea><br>
<button style='width:150px;margin-top:5px;'  onclick='sendMsg();' style='float:left;' class='btn btn-primary start'><i class='icon-upload icon-white'></i><span>Send</span></button>
</div>

<script>
function sendMsg(){
		stop=true;
		$.post('msg/send.php',{from: "<?=$_SESSION['username']; ?>" ,to: "<?=$username;?>",msg: $('#message').val()},function(data){$('#message').val('Message sent!');});
	}
</script>