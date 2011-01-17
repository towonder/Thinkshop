<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!--[if IE 7]>
	<link href="/think/css/ie7.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	<link href="<?php echo HOME?>/css/admin.css" type="text/css" rel="stylesheet">	
	<?php
	//JAVASCRIPTS (and there CSS FILES):
	echo $scripts_for_layout; ?>
	<script type="text/javascript" src="<?php echo HOME?>/js/jquery-ui/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php echo HOME?>/js/jquery-ui/js/jquery-ui-1.8.2.custom.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo HOME?>/js/uploadify/uploadify.css">
	
	
	<script type="text/javascript">
	$(function() {
		
		count = 0;
		countVideo = 0;
		
		$(".draggable").draggable({
			revert: 'invalid',
			helper: 'clone',
			cursor: 'move'
		});
		$("#droppable").droppable({
			drop: function(event, ui) {
				addMedia(ui.draggable);
			}
			/*over: function(event, ui){
				window.alert('dropped');
			},
			out: function(event, ui){
				window.alert('out');
			}*/
		});		
		
		
		function addMedia($item) {
			var string = $item.attr('id');
			var id = string.substr(6);
			var type = string.substr(0,5);
			$image = $item.html();
			
			if(type == 'photo'){
				$('#droppable').append("<div class='photoitem' style='display:none' id='addedp_"+id+"'>"+$image+"</div>");
				$('#addedp_'+id).fadeIn();
			
				var name = "#p_"+id;
				if ($(name).length == 0){
					$('#hiddenForm').append("<input type='hidden' name='data[AddedPhotos]["+count+"][id]' value='"+id+"' id='p"+id+"'/>");
					count++
				}
			
			}else{
				$('#droppable').append("<div class='photoitem' style='display:none;border:0px' id='addedv_"+id+"'>"+$image+"</div>");
				$('#addedv_'+id).fadeIn();
				
				var name = "#v_"+id;
				if($(name).length == 0){
					$('#hiddenForm').append("<input type='hidden' name='data[AddedVideos]["+countVideo+"][id]' value='"+id+"' id='v"+id+"'/>");
					countVideo++
				}
				
			} 	
			
			$item.fadeOut(function() {});
			
		}
		
		
	});
	
	function togglePhoto(){
		
		if($('#photolibrary').css('display') == 'block'){
			$('#photolibrary').css('display','none');
			$('#videolibrary').css('display','block');
			$('#phototab').removeClass('currenttab');
			$('#videotab').addClass('currenttab');
		}else{
			$('#photolibrary').css('display','block');
			$('#videolibrary').css('display','none');
			$('#phototab').addClass('currenttab');
			$('#videotab').removeClass('currenttab');
			
		}
	}
	
	function toggleVideo(){
		
		if($('#videolibrary').css('display') == 'block'){
			$('#videolibrary').css('display','none');
			$('#photolibrary').css('display','block');
			$('#phototab').addClass('currenttab');
			$('#videotab').removeClass('currenttab');
		}else{
			$('#videolibrary').css('display','block');
			$('#photolibrary').css('display','none');
			$('#phototab').removeClass('currenttab');
			$('#videotab').addClass('currenttab');
			
		}
	}
	

</script>
	
	
</head>
<body>
	<div id="medialibrary">
	<?php echo $content_for_layout; ?>
	</div>
</body>

</html>
