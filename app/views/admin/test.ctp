<script type="text/javascript">// <![CDATA[
$(document).ready(function() {

$('#photoInput').uploadify({
	'uploader'  : '<?php echo HOME?>/js/uploadify/uploadify.swf',
	'script'    : '<?php echo HOME?>/admin/uploadPhotos',
	'cancelImg' : '<?php echo HOME?>/js/uploadify/cancel.png',
	'auto'      : false,
	'folder'    : '<?php echo HOME_FOLDER?>/app/webroot/files/',
	'multi'		: true,
	'fileExt'	: '*.jpg;*.png;',
	'fileDesc'	: 'Alleen .jpg en .png bestanden zijn toegestaan',
	});
});
// ]]>

</script>

<div>
	<input id="photoInput" name="fileInput" type="file"/>
	<a href="javascript:$('#photoInput').uploadifyUpload();">Upload Files</a>
	
	
</div>

	