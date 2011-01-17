<?php

	$filesizes = getimagesize(HOME . $photo['Photo']['large']);
	$orWidth = $filesizes[0];
	$orHeight = $filesizes[1];


?>

<script src="<?php echo HOME?>/js/jCrop.min.js"></script>
<link rel="stylesheet" href="<?php echo HOME?>/js/css/jCrop.css" type="text/css" />

<script language="Javascript">

	// Remember to invoke within jQuery(window).load(...)
	// If you don't, Jcrop may not initialize properly
	jQuery(window).load(function(){

		jQuery('#cropbox').Jcrop({
			onChange: showPreviewAndUpdate,
			onSelect: showPreviewAndUpdate,
			bgColor: 'transparent',
			aspectRatio: 1
		});

	});

	function showPreviewAndUpdate(coords)
	{
		if (parseInt(coords.w) > 0)
		{
			var rx = <?php echo THUMB_SIZE ?> / coords.w;
			var ry = <?php echo THUMB_SIZE ?> / coords.h;

			jQuery('#preview').css({
				width: Math.round(rx * <?php echo $orWidth?>) + 'px',
				height: Math.round(ry * <?php echo $orHeight?>) + 'px',
				marginLeft: '-' + Math.round(rx * coords.x) + 'px',
				marginTop: '-' + Math.round(ry * coords.y) + 'px'
			});
			
			$('#x').val(coords.x);
			$('#y').val(coords.y);
			$('#w').val(coords.w);
			$('#h').val(coords.h);
		}
	}

</script>

<?php if($type == 'photo'):?>

<h2>Bewerk Foto</h2>
<?php else: ?>
<h2>Bewerk Video</h2>
<?php endif;?>


<?php if($type == 'photo'):?>
<form name="editMedia" action="<?php echo HOME?>/admin/editMedia/<?php echo $photo['Photo']['id']?>/<?php echo $type?>" method="post">
<!-- PHOTOS: -->
<table>
	<input type="hidden" name="data[Photo][id]" value="<?php echo $photo['Photo']['id']?>">
	<tr>
		<td>
			<img src="<?php echo HOME . $photo['Photo']['thumb']?>" width="70px" />
		</td>
		<td>&nbsp;</td>
		<td valign="bottom"><input type="text" name="data[Photo][name]" class="semi_text" id="phototitle" value="<?php echo $photo['Photo']['name']?>"></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">
			<b>Lokaties:</b>
		</td>
	</tr>
	<tr>
		<td colspan="2">Klein:</td>
		<td><?php echo HOME . $photo['Photo']['thumb']?>
	</tr>
	<tr>
		<td colspan="2">Middel:</td>
		<td><?php echo HOME . $photo['Photo']['medium']?>
	</tr>
	<tr>
		<td colspan="2">Groot:</td>
		<td><?php echo HOME . $photo['Photo']['large']?></td>
	</tr>
			
</table>
<table>	
	<tr>
		<td colspan="3"><div id="opties">Thumbnail bewerken <small>(Wijzig de compositie van het kleine plaatje)</small></div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>	 
	<tr>
		<td style="width:<?php echo ($orWidth + 10)?>px">
			<img src="<?php echo HOME . $photo['Photo']['large']; ?>" id="cropbox" />
		</td>
		<td>&nbsp;</td>
		<td valign="top">
			<small>Voorvertoning:</small><br/>
			
			<div style="width:<?php echo THUMB_SIZE?>px;height:<?php echo THUMB_SIZE?>px;overflow:hidden; margin-left:5px">
				<img src="<?php echo HOME . $photo['Photo']['large'];?>" id="preview" />
			</div>
		</td>
		<input type="hidden" id="x" name="data[Photo][X]" />
		<input type="hidden" id="y" name="data[Photo][Y]" />
		<input type="hidden" id="w" name="data[Photo][W]" />
		<input type="hidden" id="h" name="data[Photo][H]" />


	</tr>
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td>
		<td style="text-align:right"><input type="submit" name="Voeg toe" value="Bewerk" class="submitbutton"></td>
	</tr>
</table>


<?php else:?>
<form name="editMedia" action="<?php echo HOME?>/admin/editMedia/<?php echo $video['Video']['id']?>/<?php echo $type?>" method="post">
<!-- VIDEO: -->
<table>
	<input type="hidden" name="data[Video][id]" value="<?php echo $video['Video']['id']?>">
	<tr>
		<td>
			<a href="<?php echo HOME?>/admin/viewVideo/<?php echo $video['Video']['id']?>" class="viewvid">
				<img src="<?php echo $video['Video']['thumb']?>" width="70px" />
			</a>
		</td>
		<td>&nbsp;</td>
		<td valign="bottom"><input type="text" name="data[Video][title]" class="semi_text" id="videotitle" value="<?php echo $video['Video']['title']?>" ></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td>
		<td style="text-align:right"><input type="submit" value="Bewerk" class="submitbutton" /></td>
	</tr>
</table>

<?php endif;?>
</form>