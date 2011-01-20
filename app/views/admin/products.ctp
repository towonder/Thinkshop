<script type="text/javascript">
	$(function() {
		
		var cat_id = '<?php echo $category["Category"]["id"]?>';
		
    	$("#sortable").sortable({
			handle : '.pin',
			placeholder: 'pinplaceholder',
			stop: function(event, ui) {
				var order = $(this).sortable('serialize').toString();
				/// loading teken laten zien
				$.ajax({ 
					url: "<?php echo HOME?>/admin/saveProductPositions/?"+order+'&catid='+cat_id,
				  	success: function(data) {
				  	}
				});
			}
		});
		
		$("#sortable").disableSelection();
	});
</script>

<div class="productform">
<h2><img src="<?php echo HOME?>/img/icons/products.png"/> Producten	<a href="<?php echo HOME?>/admin/addproduct/"class="pill add button"><span class="icon plus"></span>Nieuw product</a></h2>
</div>

<table cellpadding="0" cellspacing="0" class="productstable" style="margin-bottom:0px">
	<tr class="tablehead">
		<td width="200px"><h3><?php echo $category['Category']['name']?></h3></td>
		<?php if(count($categories) > 5):?>
		<td style="text-align:right"><small><p>Selecteer categorie:</p></small></td>
		<td width="250">
		<?php else: ?>
		<td style="text-align:right;padding-right:20px" colspan="2">	
		<?php endif; ?>
			
			<form name="selectCat" action="<?php echo HOME?>/admin/products/" method="post" id="EditForm">
				<select name="data[cat_id]">
					<?php foreach($categories as $cat):?>
						<option value="<?php echo $cat['Category']['id']?>" <?php if($cat['Category']['id'] == $category['Category']['id']){ echo 'selected'; }?>>
							<?php echo $cat['Category']['name']?>
						</option>
					<?php endforeach?>
				</select>
				<a href="#" class="pill button" onClick="submitForm()">Selecteer</a>
			</form>
		</td>	
	</tr>
	<tr>
		<th width="130px"></th>
		<th>Productnaam:</th>
		<th width="200px">Acties:</th>
	</tr>
	<tr class="altrow">
		<td colspan="3">&nbsp;</td>
	</tr>
</table>


<div id="sortable">
	<?php $i = 0;?>
	<?php if(!empty($products)):?>
	<?php foreach($products as $product):
			if($product['Product']['parent_id'] == '0'):
		
//		if($product['Product']['parent_id'] == 0 || $product['Product']['parent_id'] == '0'):
	
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			
			
	?>
		<table cellspacing="0" cellpadding="0"  class="productstable"  style="margin-top:0px" id="prod_<?php echo $product['Product']['id']?>">
			<tr <?php echo $class?>>
				<td style="text-align:left;width:120px">
				<?php if(!empty($product['Image']['thumb'])):?>
				<img src="<?php echo HOME . $product['Image']['thumb']?>" height="70px" style="margin-left:10px;padding-bottom:5px;padding-top:5px"/>
			<?php else: ?>
				<img src="<?php echo HOME?>/img/no_picture_thumb.png" height="70px" style="margin-left:10px;padding-bottom:5px;padding-top:5px"/>
			<?php endif;?>
				</td>
		
		<?php if($product['Product']['hidden'] == 1):?>
			<td style="text-align:left;"><?php echo $product['Product']['name']?> <small><b> - Concept</b></small></td>
		<?php else: ?>
			<td style="text-align:left;"><?php echo $product['Product']['name']?></td>
		<?php endif;?>
				<td width="250px">
				<div class="pin" title="Slepen om positie te veranderen"><small>Positie</small></div>
				<div class="edit"><small><a href="<?php echo HOME?>/admin/editproduct/<?php echo $product['Product']['id']?>">Bewerk</a></small></div>
				<div class="delete"><small><a href="<?php echo HOME?>/admin/deleteproduct/<?php echo $product['Product']['id']?>">Verwijder</a></small></div>
				</td>
			</tr>
		
			<?php

		// CHECK FOR CHILDREN:

		?>
		
			<?php if(!empty($product['Children'])):?>
			<tr <?php echo $class?> id="child">
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
					<div class="menuspacer"></div>
					<div class="edit"><small><a href="<?php echo HOME?>/admin/editproduct/<?php echo $child['id']?>">Bewerk</a></small></div>
					<div class="delete"><small><a href="<?php echo HOME?>/admin/deleteproduct/<?php echo $child['id']?>">Verwijder</a></small></div>
				</td>
			</tr>
			<?php endforeach?>
			<tr <?php echo $class;?>>
				<td colspan="4">&nbsp;</td>
			</tr>	
		<?php endif;?>
		</table>
	<?php endif;?>
	<?php endforeach; ?>
</div>
	<?php else:?>
	<table cellspacing="0" cellpadding="0">	
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
	</tbody>
</table>
