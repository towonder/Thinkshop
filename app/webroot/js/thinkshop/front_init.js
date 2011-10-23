$(function(){
	$(".viewphoto").fancybox({
		'zoomSpeedIn': 500,
		'zoomSpeedOut': 500,
		'overlayShow': true,
		'autoDimensions': true,
		'padding': 0,
		'margin' : 0,
		'enableEscapeButton' : true,
		'hideOnContentClick' : true,
		'centerOnScroll' : true			
	}); 	
	$(".viewvid").fancybox({
		'zoomSpeedIn': 500,
		'zoomSpeedOut': 500,
		'overlayShow': true,
		'autoDimensions': false,
		'height': 360,
		'width':480,
		'padding': 0,
		'enableEscapeButton' : true,			
	}); 
});
				
//SMART EMPTY OF NEW INPUTFIELDS
function doSmartEmpty(id, string){
	if($(id).val() == string){
		$(id).val('');
		$(id).focus();
		$(id).bind('blur', function(){
			if($(id).val() == ''){
				$(id).val(string);
			}
		})
	}
}

$(function(){
	$('#cartbutton').mouseleave(function() {
		$('#cart').slideUp('fast');
	});
	$('#cartbutton').mouseenter(function(){
		$('#cart').slideDown('fast');
	})
})		
