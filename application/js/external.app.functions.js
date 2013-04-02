var summarizit = new function(object) {
	var parent   = this;
	var iFrame = "summarizit-iFrame";
	this.load = function (app_id,thread_id,iFrame_container) {
		$(document).ready(function(){
			$('#'+iFrame_container).html("<iframe name='summarizit-iFrame' width='680' id='summarizit-iFrame' frameBorder='0' scrolling='no' src='http://www.summarizit.com/application/index.php?app_id="+app_id+"&thread_id="+thread_id+"#"+encodeURIComponent(window.location.href)+"'></iframe>");
			var guestDomain = 'www.summarizit.com';
			var windowProxy;
			function onMessage(messageEvent) {
				
				if (messageEvent.origin == "http://" + guestDomain) {
					if (messageEvent.data["status"]=="ready"){ windowProxy.post({'status':'ready'}); }
					if (messageEvent.data["height"])         {$('#'+iFrame_container+" iframe").attr("height", messageEvent.data["height"]+"px");}
				}
			}
			// Create a proxy window to send to and receive message from the guest iframe
			windowProxy = new Porthole.WindowProxy('http://' + guestDomain + '/porthole/proxy.html', 'summarizit-iFrame');
			windowProxy.addEventListener(onMessage);

		});
		
	}
}