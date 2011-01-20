<?php if(!empty($product['Photo']) || !empty($product['Video'])):?>
	<?php foreach($product['Photo'] as $foto):?>
		<div class="photoitem" id="p_<?php echo $foto['id']?>" onclick="deleteMedia(<?php echo $foto['id']?>,<?php echo $product['Product']['id']?>,'photo')">
			<img src="<?php echo HOME .'/'. $foto['thumb']?>" alt="<?php echo $foto['name']?>"><br/>
			<small>verwijder</small>
		</div>
	<?php endforeach;?>
	<?php foreach($product['Video'] as $video):?>
		<div class="photoitem videoitem" id="v_<?php echo $video['id']?>"  onclick="deleteMedia(<?php echo $video['id']?>,<?php echo $product['Product']['id']?>,'video')">
			<img src="<?php echo $video['thumb']?>" width="70px"><br/>
			<small>verwijder</small>
		</div>
	<?php endforeach;?>
<?php else: ?>
	<p>Dit product heeft nog geen media-items</p>
<?php endif;?>
