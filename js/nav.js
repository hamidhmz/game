$(document).ready(function () {
	$("#mybar").click(function(){
		$("#mybar-box").removeClass('bar-hidden');
		$("#mybar-box").addClass('bar-show');
	})
	$("#mybar-box button.close").click(function(){
		$("#mybar-box").removeClass('bar-show');
		$("#mybar-box").addClass('bar-hidden');
	})
})