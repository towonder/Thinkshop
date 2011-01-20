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


	count = 0;
	countVideo = 0;

	function addMedia(string){
		var id = string.substr(6);
		var type = string.substr(0,5);
		$item = $('#'+string);

		$image = $item.find('img');
		$src = $image.attr('src');

		if(type == 'photo'){
			var name = $('#pn_'+id).val();
			
			$('#droppable').append("<div class='photoitem' style='display:none' id='addedp_"+id+"'><img src='"+$src+"'  width='70px'/><br/><small>"+name+"</small></div>");
			$('#addedp_'+id).fadeIn();

			var name = "#p_"+id;
			if ($(name).length == 0){
				$('#hiddenForm').append("<input type='hidden' name='data[AddedPhotos]["+count+"][id]' value='"+id+"' id='p"+id+"'/>");
				count++
			}

		}else{
			name = $('#vn_'+id).val();
			
			$('#droppable').append("<div class='photoitem' style='display:none' id='addedv_"+id+"'><img src='"+$src+"' width='70px'/><br/><small>"+name+"</small></div>");
			$('#addedv_'+id).fadeIn();

			var name = "#v_"+id;
			if($(name).length == 0){
				$('#hiddenForm').append("<input type='hidden' name='data[AddedVideos]["+countVideo+"][id]' value='"+id+"' id='v"+id+"'/>");
				countVideo++
			}

		} 	

		$item.fadeOut();
	}
	
	function deleteMedia(id, product, type){
		$.ajax({ 
			url: "<?php echo HOME?>/admin/removeMediaItem/"+id+"/"+product+"/"+type,
		  	success: function(data) {
				if(type == 'photo'){
		    		$('#p_'+id).fadeOut();
				}else{
					$('#v_'+id).fadeOut();	
				}
		  	}
		});
	}
	
	function submitMediaForm(){
		$('#addMediaItems').submit();
	}