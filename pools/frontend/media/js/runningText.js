$(document).ready(function() {
	var isChrome = !!window.chrome && !!window.chrome.webstore;
	var isFirefox = typeof InstallTrigger !== 'undefined';
	$('#runningText').on('mouseover',function() {
		if(isChrome==true) {
			this.stop();
		}
		if(isFirefox == true) {
			this.setAttribute('scrollamount', 0, 0);
		}
	});
	$('#runningText').on('mouseout',function(){
		if(isChrome== true) {
			this.start();
		}
		if(isFirefox == true) {
			this.setAttribute('scrollamount', 6, 0);
		}
	});
});