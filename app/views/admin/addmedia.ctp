<script type="text/javascript" src="<?php echo HOME?>/js/uploadify/uploadify.js"></script>
<script type="text/javascript" src="<?php echo HOME?>/js/uploadify/swfobject.js"></script>
<script type="text/javascript">

$(document).ready(function() {

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
	onAllComplete: function() {
		window.location = "<?php echo HOME?>/admin/media"
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
// ]]>
</script>



<?php if($type == 'photo'):?>
<h2>Nieuwe Foto's</h2>
<?php else: ?>
<h2>Nieuwe Video</h2>
<?php endif;?>

<?php if($type == 'photo'):?>
<!-- PHOTOS: -->
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
		<td style="text-align:right">
			<input type="submit" class="submitbutton" style="width:140px" value="Upload afbeeldingen" onClick="$('#photoInput').uploadifyUpload();">
		</td>
	</tr>
</table>
<br/><br/>





<?php else:?>
<form name="addNewMedia" action="<?php echo HOME?>/admin/addmedia/" method="post">

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
			<div  class="description_text">Embed code:</div>
			<textarea name="data[File][info]" class="embedArea"></textarea><br/>
			<small>(op dit moment kunt u alleen Youtube en Vimeo video's embedden)</small>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:right"><input type="submit" value="Voeg toe" class="submitbutton" /></td>
	</tr>
</table>

<?php endif;?>
</form>