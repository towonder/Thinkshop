// FANCYBOXES:
$(function(){
	$(".lbOn").fancybox({ 'zoomSpeedIn': 500, 'zoomSpeedOut': 500, 'overlayShow': true, 'centerOnScroll' : true }); 	
	$(".addcostbox").fancybox({ 'zoomSpeedIn': 500, 'zoomSpeedOut': 500, 'centerOnScroll' : true, 'overlayShow': true, 'frameHeight': 250, 'enableEscapeButton' : true }); 
	$(".viewvid").fancybox({ 'zoomSpeedIn': 500, 'zoomSpeedOut': 500, 'overlayShow': true, 'centerOnScroll' : true, 'frameHeight': 360, 'frameWidth':480, 'enableEscapeButton' : true }); 

	$(".medialibrary").fancybox({
		'zoomSpeedIn': 500,
		'zoomSpeedOut': 500,
		'overlayShow': true,
		'height': 600,
		'width': 700,
		'margin' : 0,
		'padding' : 0,
		'enableEscapeButton' : true,
		'hideOnContentClick' : false,
		'centerOnScroll' : true,
		'type' : 'iframe',
		'onClosed'	: function() {
			if(actionName == 'editproduct'){
				$.ajax({ 
					url: homeUrl+"/admin/getproductpictures/"+id,
			  		success: function(data) {
						
						if(data != ''){
							$('#fotofiller').empty();
							$('#fotofiller').append(data);
							$('#fotofiller').fadeIn();
						}
			  		}
				});
			}
		}		
	}); 
	
	$(".medialibrary2").fancybox({
		'zoomSpeedIn': 500,
		'zoomSpeedOut': 500,
		'overlayShow': true,
		'height': 600,
		'width': 700,
		'margin' : 0,
		'padding' : 0,
		'enableEscapeButton' : true,
		'hideOnContentClick' : false,
		'centerOnScroll' : true,
		'type' : 'iframe',
		'onClosed'	: function() {
			if(actionName == 'editproduct'){
				$.ajax({ 
					url: homeUrl+"/admin/getmainpicture/"+id,
			  		success: function(data) {
						if(data != ''){
							$('#mainimgbig').hide();
							$('#mainimgbig').attr('src', data);
							$('#mainimgbig').fadeIn();
						}
			  		}
				});
			}
		}		
	}); 
});

$(document).ready(function(){
	resizeLayout();
	$('.announcements').fadeIn(1500);
	$('#CatSelector').change(function(){submitForm();});
});

$(window).resize(function(){
	resizeLayout();
});

//Tiny MCE:
tinyMCE.init({
    theme : "advanced",
    mode : "textareas",
    convert_urls : false,
	theme_advanced_resizing : true,
	plugins : "paste, fullscreen",
	width : '100%',
	height : '200',
	editor_selector : 'mceEditor'
});
		
tinyMCE.init({
    theme : "advanced",
    mode : "textareas",
    convert_urls : false,
	theme_advanced_resizing : true,
	width : '100%',
	height : '370',
	plugins : "paste, fullscreen",
	editor_selector : 'mceEditor_big'
});

function resizeLayout(){
	var newnum = $('#main').width() - 330;
	$('#fluidtable').width(newnum+'px');
}

//SMART EMPTY OF NEW INPUTFIELDS
function doSmartEmpty(id, string){
	if($(id).val() == string){
		$(id).val('');
		$(id).focus();
	}
}

function submitForm(type, concept){
	var input = '';
	if(concept == true){
		input = '<input type="hidden" name="data['+type+'][save]" value="Save">';
		$('#fluidtable').append(input);
	}else if(concept == false){
		input = '<input type="hidden" name="data['+type+'][publish]" value="Publiceer">';
		$('#fluidtable').append(input);
	}else{
		//nothing
	}
	if(type != 'Media'){
		$('#EditForm').submit();
	}else{
		$('#editMedia').submit();
	}
}