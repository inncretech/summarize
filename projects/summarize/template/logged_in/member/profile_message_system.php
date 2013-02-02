<div class="page-header">
	<h1>Message <small>system.</small></h1>
  </div>

<div class="prettyprint">
	<ul class="nav nav-tabs" style="margin-bottom:0px;">
		<li class="active"><a href="#inbox" data-toggle="tab">Inbox</a></li>
		<li><a href="#sent" data-toggle="tab">Sent</a></li>
		<li><a href="#send" data-toggle="tab">Send</a></li>
	</ul>
	<div class="tab-content" style="background-color:white;border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;border-left: 1px solid #ddd;">
		<div class="tab-pane active" id="inbox" style="padding: 11px;min-height:200px;"></div>
		<div class="tab-pane" id="sent" style="padding: 11px;min-height:200px;">Profile</div>
		<div class="tab-pane" id="send" style="padding: 11px;min-height:200px;">
			<form id="message-form" style="margin-bottom:0px;">
				<h4 id="message-status"></h4>
				<input type="text" style="width:98%%;" name="to_member_name" id="to_member_name" placeholder="To">
				<input type="text" style="width:98%%;" name="subject" id="subject"placeholder="Subject">
				<textarea  style="width:98%;resize:none;min-height:125px;" name="body" id="body" placeholder="Message"></textarea>
				<button type="submit" class="btn" id="send-message-btn" onclick="return false;" >Send</button>
			</form>
		</div>
	</div>
</div>