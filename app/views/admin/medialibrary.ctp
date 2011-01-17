<h2>Media toevoegen aan "<?php echo $product['Product']['name']?>"</h2>

<form name="addMediaItems" action="<?php echo HOME ?>/admin/addMediaToProduct/<?php echo $product['Product']['id']?>" method="post">
<table>
<tr>
	<td style="text-align:right">
	<div id="droppable">
		<div class="description_text" style="border:1px solid #cccccc;border-top:0px; margin-bottom:15px">Huidige media voor <?php echo $product['Product']['name']?></div>
		
		<?php if(!empty($product['Photo'])):?>
			<?php foreach($product['Photo'] as $photo):?>
			<div class="photoitem">
				<img src="<?php echo HOME . $photo['thumb']?>" width="70px"><br/>
					<?php if(strlen($photo['name']) > 10):?>
					<small><?php echo substr($photo['name'], 0, 10)?>...</small>
					<?php else: ?>
					<small><?php echo $photo['name']?></small>
					<?php endif; ?>
			</div>
			<?php endforeach;?>
		<?php endif;?>
		<?php if(!empty($product['Video'])):?>
			<?php foreach($product['Video'] as $video):?>
			<div class="photoitem videoitem" style="border:0px;">
				<img src="<?php echo $video['thumb']?>" width="70px"><br/>
				
					<?php if(strlen($video['title']) > 10):?>
					<small><?php echo substr($video['title'], 0, 10)?>...</small>
					<?php else: ?>
					<small><?php echo $video['title']?></small>
					<?php endif; ?>
					
				
			</div>
			<?php endforeach;?>
		<?php endif;?>
		
		
	</div>
	<small>Sleep foto's en video's naar het bovenliggende vlak om ze toe te voegen</small><input type="submit" value="Voeg media toe" class="submitbutton" />
	
	
	</td>
</tr>
<tr>
	<td></td>
</tr>
<tr>
	<td>
	<div id="phototab" class="currenttab" onclick="togglePhoto();">Foto's</div>
	<div id="videotab" onclick="toggleVideo()">Videos</div>
	<div id="photolibrary">
<?php foreach($photos as $photo):
		
		//check if the product already knows of these photos:
		$inProduct = false;
	 	foreach($product['Photo'] as $phot){
			if($phot['id'] == $photo['Photo']['id']){
				$inProduct = true;
				continue;
			}
		}
		
		if($inProduct == false):
		?>

	<div class="draggable" id="photo_<?php echo $photo['Photo']['id']?>" onlClick="addMedia(this);">
		<img src="<?php echo HOME . $photo['Photo']['thumb']?>"/>
	</div>
	<?php endif;?>
<?php endforeach;?>
	</div>
	<div id="videolibrary" style="display:none">
		<?php foreach($videos as $video):

				//check if the product already knows of these photos:
				$inProductV = false;
			 	foreach($product['Video'] as $vid){
					if($vid['id'] == $video['Video']['id']){
						$inProductV = true;
						continue;
					}
				}

				if($inProductV == false):
				?>
			<div class="draggable" id="video_<?php echo $video['Video']['id']?>">
				<img src="<?php echo $video['Video']['thumb']?>" width="70px"/>
				<small><br/>(<?php echo ucwords($video['Video']['type'])?> movie)</small>
			</div>
			<?php endif;?>
		<?php endforeach;?>
	
	
	
	</div>
	
	</td>
</tr>
</table>

<div id="hiddenForm">


</div>
</form>