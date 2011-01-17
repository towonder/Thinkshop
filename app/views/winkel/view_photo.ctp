<?php 

	$sizes = getimagesize($image);
	$width = $sizes[0];
	$height = $sizes[1];

?>
<script type="text/javascript">
	function closeBox(){
		$.fancybox.close();
	}
</script>

<img src="<?php echo $image?>" width="<?php echo $width?>" height="<?php echo $height?>" onclick="closeBox();"/>