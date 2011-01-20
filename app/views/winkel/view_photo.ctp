<?php 

	$sizes = getimagesize(str_replace(' ', '%20', $image));
	$width = $sizes[0];
	$height = $sizes[1];

?>
<img src="<?php echo $image?>" width="<?php echo $width?>" height="<?php echo $height?>"/>