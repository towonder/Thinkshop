<div class="products">
	
	<div class="producttop">
		<img src="/knip/img/stelsamenkop.png">
	</div>

	<div class="order">
		<form name="editorder" action="/knip/products/ordertosession/" method="post">
			<input type="hidden" name="data[Order][id]" value="<?php echo $product['Product']['id']?>">
			
			<div class="details">
				
				<div class="tussenkopje"><p>Selecteer uw maat:</p></div>
				<?php if($product['Product']['size_id'] == '0'):?>
				<div class="productsizes">
					<table>
						<tr>
							<th style="width:10px"></th>
							<th>Bovenwijdte</th>
							<th>Taillewijdte</th>
							<th>Heupwijdte</th>
							<th>Selecteer</th>
						</tr>
						<tr>
							<td colspan="5" class="border"></td>
						</tr>
						<tr>
							<td><b>M:</b></td>
							<td>88cm - 92cm</td>
							<td>70cm - 74cm</td>
							<td>94cm - 98cm</td>
							<td><input type="radio" name="data[Order][size]" value="M" checked></td>
						</tr>
						<tr>
							<td colspan="5" class="border"></td>
						</tr>
						<tr>
							<td><b>L:</b></td>
							<td>92cm - 96cm</td>
							<td>74cm - 78cm</td>
							<td>98cm - 102cm</td>
							<td><input type="radio" name="data[Order][size]" value="L"></td>
						</tr>
						<tr>
							<td colspan="5" class="border"></td>
						</tr>
						<tr>
							<td><b>XL:</b></td>
							<td>96cm - 100cm</td>
							<td>78cm - 82cm</td>
							<td>102cm - 106cm</td>
							<td><input type="radio" name="data[Order][size]" value="X"></td>
						</tr>
						<tr>
							<td colspan="5" class="border"></td>
						</tr>
					</table>
				</div>
				<?php else: ?>
				<div class="productsizes">
					<table>
						<tr>
							<th style="width:10px"></th>
							<th>Bovenwijdte</th>
							<th>Taillewijdte</th>
							<th>Heupwijdte</th>
							<th>Selecteer</th>
						</tr>
						<tr>
							<td colspan="5" class="border"></td>
						</tr>
						<tr>
							<td><b>XL:</b></td>
							<td>96cm - 100cm</td>
							<td>78cm - 82cm</td>
							<td>102cm - 106cm</td>
							<td><input type="radio" name="data[Order][size]" value="X" checked></td>
						</tr>
					</table>
				</div>	
				<?php endif; ?>
				<div class="tussenkopje"><p>Eventuele opmerking:</p></div>
				<div class="productsizes">
					<table><tr><td>
					<textarea name="data[Order][opmerking]" rows="5" style="width:95%; margin-left:2.5%"></textarea>
					</td></tr></table>
				</div>
				<div class="tussenkopje"><p>Selecteer uw stof:</p></div>

				<div class="fabrics">
					<table>
						<tr>
							<th width="70px">Stof</th>
							<th>Omschrijving</th>
							<th>Selecteer</th>
						</tr>
						<?php $a = true; ?>
						<?php foreach($product['Fabrick'] as $fabric):?>
						<tr>
							<td><a href="/knip/products/showfabric/<?php echo $fabric['id']?>" class="lbOn"><img src="<?php echo $fabric['image']?>"></a></td>
							<td style="text-align:center"><?php echo $fabric['description']?></td>
							<td style="text-align:right"><input type="radio" name="data[Order][fabric]" value="<?php echo $fabric['add']?>" <?php if($a == true){ echo 'checked'; $a = false;}?>></td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>

			</div>
			<table width="100%">
				<tr style="text-align:right" width="100%">
					<td><br/><input type="submit" value="Ga door met bestellen >"></td>
				</tr>
			</table>
		</form>
	</div>

</div>