<script type="text/javascript" src="<?php echo HOME?>/js/uploadify/uploadify.js"></script>
<script type="text/javascript" src="<?php echo HOME?>/js/uploadify/swfobject.js"></script>
<script type="text/javascript">

$(document).ready(function() {

var gaveError = false;

$('#photoInput').uploadify({
	'uploader'  : '<?php echo HOME?>/js/uploadify/uploadify.swf',
	'script'    : '<?php echo HOME?>/uploadPhotos',
	'cancelImg' : '<?php echo HOME?>/js/uploadify/cancel.png',
	'auto'      : false,
	'folder'    : '<?php echo HOME_FOLDER?>/app/webroot/files/',
	'multi'		: true,
	'fileExt'	: '*.jpg;*.png;',
	'fileDesc'	: 'Alleen .jpg en .png bestanden zijn toegestaan',
	'width'		: '172',
	'height'	: '34',
	
	onComplete: function(event, ID, fileObj, response, data){
		if(response != 'upload_okay'){
			$('#err').empty();
			$('#err').hide();
			$('#err').append('<p>'+response+'</p>');
			$('#err').fadeIn('slow');
			gaveError = true;
			$('#photoInput').uploadifyClearQueue();
			$('#uploadbtn').fadeOut('slow');
		}
	},
	onAllComplete: function() {
		if(gaveError == false){
			window.location = "<?php echo HOME?>/admin/media"
		}
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
});

function submitMovie(){
	$('#addVideo').submit();
}

// ]]>
</script>



<?php if($type == 'photo'):?>
<h2>Nieuwe Foto's</h2>
<?php else: ?>
<h2>Nieuwe Video</h2>
<?php endif;?>

<?php if($type == 'photo'):?>
<!-- PHOTOS: -->
<div id="err" style="display:none">

</div>
<table>
		
	<tr>
		<div id="photoform">
			<input id="photoInput" name="fileInput" type="file"/>
		</div>		
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:left">
			<a href="#" class="pill giant button" style="padding-top:5px;padding-bottom:5px;margin-left:400px;" onClick="$('#photoInput').uploadifyUpload();" id="uploadbtn">Upload afbeeldingen</a>
		</td>
	</tr>
</table>
<br/><br/>





<?php else:?>
<form name="addNewMedia" action="<?php echo HOME?>/admin/addmedia/" method="post" id="addVideo">

<!-- VIDEO: -->
<table>
	<tr>
		<td><input type="text" name="data[Video][title]" class="semi_text" id="videotitle" value="Video titel" onclick="doSmartEmpty('#videotitle', 'Video titel');"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:center">
			<div  class="description_text" style="width:100%">Embed code:</div>
			<textarea name="data[File][info]" class="embedArea"></textarea><br/>
			<small>(op dit moment kunt u alleen Youtube en Vimeo video's embedden)</small>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:right">
			<a href="#" class="pill giant button" onClick="submitMovie()">Voeg toe</a>
		</td>
	</tr>
</table>

<?php endif;?>
</form>