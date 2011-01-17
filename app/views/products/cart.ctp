<div class="products">

	<div class="producttop">
		<img src="/knip/img/winkelwagenkop.png">
	</div>

	<div class="cart">
		<table>
			<tr>
				<th colspan="2" style="margin-left:10px">Artikelen</th>
				<th >Maat</th>
				<th style="text-align:center">Stof</th>
				<th style="text-align:center">Levertijd</th>
				<th style="text-align:center">Prijs</th>
				<th></th>
			</tr>
			<tr>
				<td colspan="7" class="border"></td>
			</tr>
			<?php $amountProducts = 0;?>
			<?php $amountPrice = 0; ?>
			<?php $amountSend = 0; ?>
			
			<?php if(!empty($products)):?>
			<?php foreach($products as $product):?>
			<tr>
				<td valign="center"><img src="<?php echo $product['image']?>" width="50px"></td>
				<td valign="center"><?php echo $product['name']?><br/>
				</td>
				<td valign="center"><?php echo $product['size']?></td>
				<td valign="center" style="text-align:center"><img src="<?php echo $product['fabric_img']?>"></td>
				<td valign="center" style="text-align:center"><?php echo $product['deliver']?></td>
				<td valign="center"style="text-align:center"><?php echo $number->currency($product['price'], 'EUR')?></td>
				<td valign="center"style="text-align:center"><a href="/knip/products/removefromcart/<?php echo key($products)?>">Verwijder</a></td>
			</tr>
			<tr>
				<td colspan="7" class="border"></td>
			</tr>
			<?php
				$amountProducts++;
				$amountPrice += $product['price'];
				$amountSend += $product['sendcost'];
			
			?>
			<?php endforeach;?>
			<tr>
				<td colspan="5"><a href="/knip/">Shop verder</a></td>
			</tr>
		
			<?php else: ?>
			<tr>
				<td colspan="5" class="wide"><br/>Er zitten nog geen artikelen in uw winkelwagentje! <a href="/knip/products/">Bekijk de collectie!</a><br/><br/></td>
			</tr>
			<?php endif; ?>
			
		
		</table>
		<div class="receipt">
			<table>
				<tr>
					<td>Totaal artikelen (<?php echo $amountProducts?>)</td>
					<td style="text-align:right"><?php echo $number->currency($amountPrice, 'EUR')?></td>
				</tr>
				<tr>
					<td colspan="2" class="borderdotted">
				</tr>
				<tr>
					<td>Subtotaal</td>
					<td style="text-align:right"><?php echo $number->currency($amountPrice,'EUR') ?></td>
				</tr>
				<tr>
					<td>Verzendkosten</td>
					<td style="text-align:right"><?php echo $number->currency($amountSend,'EUR')?></td>
				</tr>
				<tr>
					<td colspan="2" class="borderdotted">
				</tr>
				<tr>
					<td><b>totaal</b></td>
					<td style="text-align:right"><?php echo $number->currency($amountPrice + $amountSend,'EUR')?></td>
				</tr> 
			</table><br/>
			<table class="move_on">
				<tr><td>
					<a href="/knip/products/user/false">
					Ga verder met uw bestelling >
					</a>
				</td></tr>
			</table>
		</div>

		
	</div>


</div>