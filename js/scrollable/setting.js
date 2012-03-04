$(document).ready(function() {
$(".main").scrollable({
	vertical: true,
	keyboard: 'static',
	onSeek: function(event, i) {
		horizontal.eq(i).data("scrollable").focus();
	}
}).navigator(".main_navi");
var horizontal = $(".scrollable").scrollable({ circular: true }).autoscroll(6000).navigator(".navi");
horizontal.eq(0).data("scrollable").focus();
}); 
