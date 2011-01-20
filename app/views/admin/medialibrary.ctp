<?php if($autoclose == 'true'):?>
<script type="text/javascript">

	$(document).ready(function(){
		parent.$.fancybox.close();
	});

</script>

<?php endif;?>

<h2>Media toevoegen aan "<?php echo $product['Product']['name']?>"</h2>

<form id="addMediaItems" action="<?php echo HOME ?>/admin/addMediaToProduct/<?php echo $product['Product']['id']?>" method="post">
<table style="width:680px">
<tr>
	<td style="text-align:right">
	<div id="droppable">
		<div class="description_text" style="border:1px solid #cccccc;border-top:0px; margin-bottom:15px">Huidige media voor <?php echo $product['Product']['name']?></div>
		<?php if(!empty($product['Photo'])):?>
			<?php foreach($product['Photo'] as $photo):?>
			<div class="photoitem" onclick="deleteMedia(<?php echo $photo['id']?>,<?php echo $product['Product']['id']?>,'photo')" id="p_<?php echo $photo['id']?>">
			<div class="deletethismedia"></div>	
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
			<div class="photoitem videoitem" style="border:0px;" onclick="deleteMedia(<?php echo $video['id']?>,<?php echo $product['Product']['id']?>,'video')" id="v_<?php echo $video['id']?>">
				<div class="deletethismedia"></div>	
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
	<a href="#" class="pill giant button" onclick="submitMediaForm()" style="margin-right:25px">Voeg toe</a>
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
<?php $i = 0; ?>
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
		$class = ' class="row"';
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		
		?>
	<div <?php echo $class?> id="photo_<?php echo $photo['Photo']['id']?>" onclick="addMedia('photo_<?php echo $photo['Photo']['id']?>')" >
		<input type="hidden" name="n" value="<?php echo $photo['Photo']['name']?>" id="pn_<?php echo $photo['Photo']['id']?>"/>
		<table cellspacing="0" cellpadding="0" style="width:625px">
		<tr <?php echo $class?>>
		<td <?php echo $class?> style="width:90px">	
			<img src="<?php echo HOME . $photo['Photo']['thumb']?>" />
		</td>
		<td <?php echo $class?>  style="width:440px">
			<p><?php echo $photo['Photo']['name']?></p>
			<small><?php echo date('d-m-Y', strtotime($photo['Photo']['created'])); ?></small>
		</td>
		<td <?php echo $class?>>
			<b>Voeg toe</b>
		</td>
		</tr>
		</table>
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
					$class = ' class="row"';
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				
				?>
				<div <?php echo $class?> id="video_<?php echo $video['Video']['id']?>" onclick="addMedia('video_<?php echo $video['Video']['id']?>')" >
					<input type="hidden" name="n" value="<?php echo $photo['Photo']['name']?>" id="vn_<?php echo $photo['Photo']['id']?>"/>
					
					<table cellspacing="0" cellpadding="0" style="width:625px">
					<tr <?php echo $class?>>
					<td <?php echo $class?> style="width:90px">	
						<img src="<?php echo $video['Video']['thumb']?>" />
					</td>
					<td <?php echo $class?>  style="width:440px">
						<p><?php echo $video['Video']['title']?></p>
						<small><?php echo date('d-m-Y', strtotime($video['Video']['created'])); ?></small>
					</td>
					<td <?php echo $class?>>
						<b>Voeg toe</b>
					</td>
					</tr>
					</table>
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