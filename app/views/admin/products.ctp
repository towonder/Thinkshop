<div class="productform">
<h2><img src="<?php echo HOME?>/img/icons/products.png"/> Producten	<a href="<?php echo HOME?>/admin/addproduct/" class="addnewbutton">Nieuw product</a></h2>
</div>

<table cellpadding="0" cellspacing="0" class="productstable">
	<tr class="tablehead">
		<td width="200px"><h3><?php echo $category['Category']['name']?></h3></td>
		<td style="text-align:right"><small><p>Selecteer categorie:</p></small></td>
		<td width="250">
			<form name="selectCat" action="<?php echo HOME?>/admin/products/" method="post">
				<select name="data[cat_id]">
					<?php foreach($categories as $cat):?>
						<option value="<?php echo $cat['Category']['id']?>" <?php if($cat['Category']['id'] == $category['Category']['id']){ echo 'selected'; }?>>
							<?php echo $cat['Category']['name']?>
						</option>
					<?php endforeach?>
				</select>
				<input type="submit" name="Selecteer" value="Selecteer" class="submitbuttonsmall">
			</form>
		</td>	
	</tr>
	<?php if($amountProducts > AMOUNT_ON_PAGE):?>
	<tr class="tablefooter" style="height:10px">
		<td colspan="4" class="tablefooter" style="height:10px">			
			<div class="paginator_normal">
				<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
			</div>
		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<th width="130px"></th>
		<th>Productnaam:</th>
		<th width="200px">Acties:</th>
	</tr>
	<tr class="altrow">
		<td colspan="3">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php if(!empty($products)):?>
	<?php foreach($products as $product):
		
//		if($product['Product']['parent_id'] == 0 || $product['Product']['parent_id'] == '0'):
	
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			
			//print_r($product);
			
	?>
	<tr<?php echo $class;?>>
		<td style="text-align:left;">
			<?php if(!empty($product['Image']['thumb'])):?>
				<img src="<?php echo HOME . $product['Image']['thumb']?>" height="70px" style="margin-left:10px;padding-bottom:5px;padding-top:5px" />
			<?php else: ?>
				<img src="<?php echo HOME?>/img/no_picture_thumb.png" height="70px" style="margin-left:10px;padding-bottom:5px;padding-top:5px" />
			<?php endif;?>
		</td>
		<td style="text-align:left;"><?php echo $product['Product']['name']?></td>
		<td width="200">
			<div class="edit"><small><a href="<?php echo HOME?>/admin/editproduct/<?php echo $product['Product']['id']?>">Bewerk</a></small></div>
			<div class="delete"><small><a href="<?php echo HOME?>/admin/deleteproduct/<?php echo $product['Product']['id']?>">Verwijder</a></small></div>
		</td>
	</tr>
	<?php
	
	// CHECK FOR CHILDREN:
	
	?>
	
	<?php if(!empty($product['Children'])):?>
	<tr <?php echo $class?>>
		<td></td>
		<td colspan="3" class="varianten">
			Varianten:
		</td>
	</tr>		
		<?php foreach($product['Children'] as $child):?>
		<tr <?php echo $class?>>
		
			<td></td>
			<td class="variant"><?php echo $child['name']?></td>
			<td>
				<div class="edit"><small><a href="<?php echo HOME?>/admin/editproduct/<?php echo $child['id']?>">Bewerk</a></small></div>
				<div class="delete"><small><a href="<?php echo HOME?>/admin/deleteproduct/<?php echo $child['id']?>">Verwijder</a></small></div>
			</td>
		</tr>
		<?php endforeach?>
	<tr <?php echo $class;?>>
		<td colspan="4">&nbsp;</td>
	</tr>	
	<?php endif;?>
	</tr>
	
	<?//php endif;?>
	<?php endforeach; ?>
	<?php if($amountProducts > AMOUNT_ON_PAGE):?>
	<tr class="tablefooter">
		<td colspan="4" class="tablefooter">			
			<div class="paginator_normal">
				<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
			</div>
		</td>
	</tr>
	<?php endif; ?>
	
	<?php else:?>
	<tr class="altrow">
		<td colspan="3" style="text-align:center; padding-top:10px; padding-top:10px">In deze categorie staan nog geen producten.</td>
	</tr>
	<tr class="altrow">
		<td colspan="3" style="text-align:center; padding-top:10px; padding-top:10px"><a href="<?php echo HOME?>/admin/addproduct/">Voeg nieuw product toe »</a></td>
	</tr>
	<tr class="altrow">
		<td colspan="3" style="text-align:center; padding-top:10px; padding-top:10px">&nbsp;</td>
	</tr>
	<?php endif;?>
</table>
