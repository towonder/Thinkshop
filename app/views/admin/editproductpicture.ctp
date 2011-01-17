<?php $prod_id = $product['Product']['id']; ?>
<script type="text/javascript" src="<?php echo HOME?>/js/uploadify/uploadify.js"></script>
<script type="text/javascript" src="<?php echo HOME?>/js/uploadify/swfobject.js"></script>
<script type="text/javascript">

$(document).ready(function() {

$('#photoInput').uploadify({
	'uploader'  : '<?php echo HOME?>/js/uploadify/uploadify.swf',
	'script'    : '<?php echo HOME?>/uploadPhotos/<?php echo $prod_id?>',
	'cancelImg' : '<?php echo HOME?>/js/uploadify/cancel.png',
	'auto'      : false,
	'folder'    : '<?php echo HOME_FOLDER?>/app/webroot/files/',
	'multi'		: false,
	'fileExt'	: '*.jpg;*.png;',
	'fileDesc'	: 'Alleen .jpg en .png bestanden zijn toegestaan',
	'width'		: '172',
	'height'	: '34',
	onAllComplete: function() {
		window.location = "<?php echo HOME?>/admin/editproductpicture/<?php echo $prod_id?>"
	   },
	/*
	onError: function (a, b, c, d) {
	         if (d.status == 404)
	            alert('Could not find upload script. Use a path relative to: '+'<?= getcwd() ?>');
	         else if (d.type === "HTTP")
	            alert('error '+d.type+": "+d.status);
	         else if (d.type ==="File Size")
	            alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
	         else
	            alert('error '+d.type+": "+d.text);
	}*/
	});
	
	
	$("#mainimagedrop").droppable({
		drop: function(event, ui) {
			addMainImage(ui.draggable);
		}
	});
	
	function addMainImage($item){
		var string = $item.attr('id');
		var id = string.substr(6);
		
		$.ajax({ 
			url: "<?php echo HOME?>/admin/saveproductpicture/"+id+"/<?php echo $prod_id?>",
	  		success: function(data) {
				window.location = "<?php echo HOME?>/admin/editproductpicture/<?php echo $prod_id?>"	
	  		}
		});
	}
	
	
	
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
</script>
<h2>Nieuwe hoofdafbeelding</h2>
<table>
	<tr>
		<td>
			<div id="mainimagedrop">
				<div class="description_text" style="border:1px solid #cccccc;border-top:0px; margin-bottom:15px;">Huidige hoofdafbeelding</div>
				<?php if(!empty($product['Image']['large'])):?>
					<img src="<?php echo HOME . $product['Image']['large']?>" height="183px">
				<?php else: ?>
					<img src="<?php echo HOME?>/img/no_picture_large.png" height="183px">
				<?php endif;?>
				
			</div>
		</td>
		<td>
			<div id="mainimageupload">
				<div class="description_text" style="border:1px solid #cccccc;border-top:0px;margin-bottom:15px">Nieuwe afbeelding uploaden</div>
				<table style="width:500px">
					<tr>
						<td><input id="photoInput" name="fileInput" type="file"/></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr style="text-align:right">
						<td><input type="submit" class="submitbutton" style="width:140px;margin-right:0px" value="Upload afbeelding" onClick="$('#photoInput').uploadifyUpload();"></td>
					</tr>
				</table>
			</div>
		<td>
			
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center; height:40px"><small>Sleep een foto naar het 'huidige hoofdafbeelding' vak om deze toe te voegen</small></td>			
	<tr>
		<td colspan="2">
			<div id="mainphotolibrary">
				<div class="description_text" style="border:1px solid #cccccc;border-top:0px;margin-bottom:15px">Fotobibliotheek</div>
				<div id="photosinlibrary">
			<?php foreach($photos as $photo):

					if($photo['Photo']['id'] != $product['Product']['photo_id']):
					?>

				<div class="draggable" id="photo_<?php echo $photo['Photo']['id']?>" onlClick="addMedia(this);">
					<img src="<?php echo HOME . $photo['Photo']['thumb']?>"/>
				</div>
				<?php endif;?>
			<?php endforeach;?>
			</div>
			
			</div>
		</td>
	</tr>
</table>
		