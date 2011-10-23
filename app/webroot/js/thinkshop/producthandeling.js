
var count = 0;
var photocount = 0;
var videocount = 0;


function showVariant(){
	if($('#variant').css('display','none')){
		$('#variant').css('display','inline');
	}			
};

function createNewCategory(){
	
	$("#loading").ajaxStart(function(){
		$(this).show();
		$('#searchbtn').hide();
	});
	$("#loading").ajaxStop(function(){
		$(this).hide();
		$('#searchbtn').show();
	});
	
	
	var name = $('#newcatname').val();
	$('#newcatname').val('Nieuwe categorie');
	
	$.ajax({
		url: js_home+"/admin/quickaddcategory/"+name,
		success: function(data){
			var newid = data;
			
			var div = '<div class="catspan">';
			div += "<div class='catselection' id='cate_"+newid+"'>";
			div += "<input type='checkbox' name='data[ProdCats][c_"+newid+"]' checked value='"+newid+"'/>";
			div += "<p style='display:inline;font-weight:bold'>"+name+"</p></div></div>";
			
			$('#oldcats').append(div);
			$('#cate_'+newid).effect("highlight", { times:2 }, 300);
			
		}
	});
}

function createTag(){
	
	
	var newTags = $('#newtagname').val();
	newTags = new String(checkTags(removeSpaces(newTags)));

	var currentVal = $('#currenttags').val();
	$('#currenttags').val(currentVal+newTags);
		
	var prod_id = $('#product_id_field').val();	
	$.ajax({
		url: js_home+"/admin/addtags/"+newTags+"/"+prod_id,
		success: function(data){
			if(data != null && data != ''){
				$('#oldtags').append(data);
				bindTagClicks();
				if(js_lang == 'eng'){
					$('#newtagname').val('Separate tags with a comma');
				}else{
					$('#newtagname').val('Tags scheiden met een comma');
				}
				
			}
		}
	})
}

function checkTags(string){
	
	var tags = $('#currenttags').val();
	tags = removeSpaces(tags);	
	
	var newTags = string.split(',');
	var oldTags = tags.split(',');
	var tagString = '';
	
	for(var i = 0; i < newTags.length; i++){
		if(newTags[i] != '' && newTags[i] != null){
			var inOld = false;
			for(var a = 0; a < oldTags.length; a++){
				if(newTags[i] == oldTags[a]){
					inOld = true;
				}
			}
			if(inOld == false){
				tagString += newTags[i]+',';
			}
		}
	}
	return tagString;
}

function removeTag(string){
	var tags = $('#currenttags').val();
	tags = removeSpaces(tags);		
	var oldTags = tags.split(',');
	var tagString = '';
	for(var i = 0; i < oldTags.length; i++){
		if(oldTags[i] != '' && oldTags[i] != null){ 
			if(oldTags[i] != string){
				tagString += oldTags[i]+',';
			}
		}
	}
	$('#currenttags').val(tagString);
}


function removeSpaces(string) {
	return string.split(' ').join('');
}

function bindTagClicks(){
	$('.deletetag').click(function(){
		var id = $(this).attr('id').substring(4);
		var prod_id = $('#product_id_field').val();	
		
		var text = $('#tagcontainer_'+id).find('p').text();
		removeTag(text);
		
		
		$.ajax({
			url: js_home+"/admin/deletetag/"+id+"/"+prod_id,
			success: function(data){
				if(data != 'error'){
					$('#tagcontainer_'+id).fadeOut('slow');
				}
			}
		})
	})
}


function doDeleteMeta(id) {
	var name = "#meta_"+id;
	if ($(name).length == 0){
		$('#deletedMeta').append("<input type='hidden' name='data[DeletedMeta]["+count+"][id]' value='"+id+"' id='meta_"+id+"'/>");
		count++
	}else{
		$(name).remove();
	}
}


function deleteMedia(id, product, type){
	$.ajax({ 
		url: js_home+"/admin/removeMediaItem/"+id+"/"+product+"/"+type,
	  	success: function(data) {
			if(type == 'photo'){
	    		$('#p_'+id).fadeOut();
			}else{
				$('#v_'+id).fadeOut();	
			}
	  	}
	});
}

$(document).ready(function(){
	bindTagClicks();
})