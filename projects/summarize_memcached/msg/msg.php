
<div id="msg-container">
<div id='title'>Messages:</div>
<div id='block'></div>
	<ul id="msg-menu">
		<li><a href="javascript:void(0);" id="send" onClick="send();">Send</a><li>
		<li><a href="javascript:void(0);" id="received" onClick="stop=false;received();">Received</a><li>
		<li><a href="javascript:void(0);" id="sent" onClick="sent();">Sent</a><li>
	</ul>
<div id="msg-content">
</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
 <script src="js/jquery.tagify.js"></script>
<script>
    send();
	var stop=true;
	var rlimit=0;
	var slimit=0;
	function send(){
		stop=true;
		var form = "<textarea id='to' style='width:895px;'></textarea><textarea style=' resize:none;width:500px;height:100px;margin-top:5px;' id='message' placeholder='Message...'></textarea><br>";
		    form = form + "<button style='width:150px;margin-top:5px;'  onclick='sendMsg();' style='float:left;' class='btn btn-primary start'><i class='icon-upload icon-white'></i><span>Send</span></button>";
		$('#msg-content').html(form);
		msgTagify();
	}
	function sendMsg(){
		stop=true;
		$.post('msg/send.php',{from: "<?=$username; ?>" ,to: $('#to').tagify('serialize'),msg: $('#message').val()},function(data){$('#message').val('Message sent!');});
	}
	
	function received(){
		if (stop) return;
		$.post('msg/received.php',{user: "<?=$username; ?>", limit: rlimit},function(data){$('#msg-content').html(data);});
		setTimeout(function(){received();},10000);
	}
	
	function sent(){
		stop=true;
		$.post('msg/sent.php',{user: "<?=$username; ?>" , limit: slimit},function(data){$('#msg-content').html(data);});
	}
	function nextRecived(){
		rlimit +=10;
		received();
	}
	function backRecived(){
		if (rlimit!=0)rlimit -=10;
		received();
	}
	function nextSent(){
		slimit +=10;
		sent();
	}
	function backSent(){
		if (slimit!=0)slimit -=10;
		sent();
	}
	function startTimer(){stop=false;setTimeout(function(){received();},10000);}

    function msgTagify(){
	var msgTagArea = $('#to').tagify();
	msgTagArea.tagify('inputField').autocomplete({
		source: [ <?php 
		$data=$database->query("SELECT * FROM `users`");
		$unique_tags = array();
		while ($info=mysql_fetch_array($data))
		{
			array_push($unique_tags,$info['username']);
		}
		$unique_tags=array_unique($unique_tags);
		$str=null;
		foreach ($unique_tags as &$tag) 
		{
			$str=$str.'"'.$tag.'",';
		}
		$str=substr_replace($str ,"",-1);
		echo $str;
		?>],
		position: { of: msgTagArea.tagify('containerDiv') },
		close: function(event, ui) { msgTagArea.tagify('add'); }
	});
	$('.ui-autocomplete-input').attr("placeholder",'Add friends');
	}
</script>


