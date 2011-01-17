<?php

	$sizes = getimagesize(HOME . $product['Image']['large']);
	$width = $sizes[0];

?>

<div id="mainimage">
	<?php if($width < 330):?>
	<img src="<?php echo HOME . $product['Image']['large'];?>" width="<?php echo $width?>px" />
	<?php else:?>
	<img src="<?php echo HOME . $product['Image']['large'];?>" width="330px">
	<?php endif;?>
</div>
<div id="maininfo">
<table>
	<tr>
		<td colspan="2" style="border:0px;padding:0px"><b class="big"><?php echo $product['Product']['name']?></b></td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $product['Product']['description']?></td>
	</tr>
	<?php if(!empty($product['Extrafields'])):?>
	<?php foreach($product['Extrafields'] as $field):?>
	<tr>
		<td style="width:270px"><?php echo $field['name'] ?>:</td>
		<td><b><?php echo $field['value']?></b></td>
	<?php endforeach;?>
	<?php endif;?>
	
	<?php if(empty($product['Children'])):?>
	<tr>
		<?php
			
			$prijs = $product['Product']['price'] + ($product['Product']['price'] * $product['Product']['vat']);
		
		?>
		<td style="width:270px" valign="bottom">Prijs:</td>
		<td><b class="big"><?php echo $number->currency($prijs, 'EUR')?></b></td>
	</tr>
	<?php else: ?>
	<tr>
		<td colspan="2" style="border:0px">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="border-top:1px dotted #cccccc; font-style:italic;text-align:center">Varianten:</td>
	</tr>
	<?php foreach($product['Children'] as $child):?>
	<tr>
		<?php
			
			$prijs = $child['price'] + ($child['price'] * $child['vat']);
		
		?>
		<td style="width:270px" valign="bottom"><?php echo $child['name']?> :</td>
		<td><b class="big"><?php echo $number->currency($prijs, 'EUR')?></b></td>
	</tr>
	<?php endforeach;?>
	<?php endif;?>
	
	<tr>
		<td style="padding-top:15px;padding-bottom:15px;text-align:right;border-bottom:0px" colspan="2">
			<a href="<?php echo HOME?>/winkel/addtocart/<?php echo $product['Product']['id']?>">
				<img src="<?php echo HOME?>/img/frontside/incart.jpg"/>
			</a>
		</td>
	</tr>
	
	<?php if(!empty($product['Photo'])):?>
	<tr>
		<td colspan="2" style="text-align:center;font-style:italic;border-top:1px dotted #cccccc">Foto's</td>
	</tr>
	<tr>
		<td colspan="2" style="border:0px;text-align:center">
			<?php foreach($product['Photo'] as $photo):?>
			<?php
			
				$sizes = getimagesize(HOME . $photo['large']);
				$width = $sizes[0];
				$height = $sizes[1];
			
			
			?>
			<div class="photoitem">
				<img src="<?php echo HOME . $photo['thumb']?>" width="50px" onclick="fancybox('<?php echo HOME?>/winkel/viewPhoto/<?php echo $photo['id']?>', <?php echo $width?>, <?php echo $height?>)"/>
			</div>
			
			<?php endforeach;?>
		</td>
	</tr>
	<?php endif;?>
	<?php if(!empty($product['Video'])):?>
	<tr>
		<td colspan="2" style="text-align:center;border-top:1px dotted #cccccc;font-style:italic">Video's</td>
	</tr>
	<tr>
		<td colspan="2" style="border:0px;text-align:center">
			<?php foreach($product['Video'] as $video):?>
			<div class="photoitem">
				<a href="<?php echo HOME?>/winkel/viewVideo/<?php echo $video['id']?>" class="viewvid">
					<img src="<?php echo $video['thumb']?>" width="50px"/>
				</a>
			</div>
			<?php endforeach;?>
		</td>
	</tr>
	<?php endif;?>
	
	
</table>
</div>