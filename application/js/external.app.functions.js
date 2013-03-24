var summarizit = new function(object) {
	var parent   = this;
	var iFrame = "summarizit-iFrame";
	this.load = function (app_id,thread_id,iFrame_container) {
		$(document).ready(function(){
			$("#container").html("<iframe name='summarizit-iFrame' width='650' id='summarizit-iFrame' frameBorder='0' scrolling='no' src='http://www.summarizit.com/application.php?app_id="+app_id+"&thread_id="+thread_id+"#"+encodeURIComponent(window.location.href)+"'></iframe>");
			var guestDomain = 'www.summarizit.com';
			var windowProxy;
			function onMessage(messageEvent) {
				if (messageEvent.origin == "http://" + guestDomain) {
					$("#container iframe").attr("height", messageEvent.data["height"]+"px");
				}
			}
			window.onload=function(){ 
				// Create a proxy window to send to and receive message from the guest iframe
				windowProxy = new Porthole.WindowProxy('http://' + guestDomain + '/porthole/proxy.html', 'summarizit-iFrame');
				windowProxy.addEventListener(onMessage);
				windowProxy.post({'status':'ready'})
				console.log("Ready sent...");
			};
		});
		
	}
}