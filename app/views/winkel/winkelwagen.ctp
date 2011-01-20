<?php $totalPrice = 0;?>
<?php $totalSend = 0; ?>
<div id="cartdiv">
<?php if(!empty($cart)):?>
<table cellspacing="0" cellpadding="0">
	<tr>
		<th width="70px"></th>
		<th>Product</th>
		<th>Aantal</th>
		<th>Prijs</th>
		<th>Verwijder</th>
	</tr>	
<?php foreach($cart as $it):?>
	<?php $amount = 0;?>
	<?php if(!empty($it[0]['Options'])):?>
	<?php $i = 0;?>
	<?php foreach($it as $item):?>
		<tr>
			<td>
				<img src="<?php echo HOME . $item['thumb']?>" width="70px"/>
			</td>
			<td style="text-align:left; padding-left:25px">
				<?php echo $item['name']?><br/>
				<small>
					<?php foreach($item['Options'] as $option):?>
						<?php echo $option['name'] .': '. $option['value'] .'<br/>';?>
					<?php endforeach;?>
				</small>
			</td>
			<td><b>1</b></td>
			<td>
				<?php $prijs = $item['price'] + ($item['price'] * $item['vat']); ?>
				<?php
				
					if($item['discount'] > 0){
						$discount = 1 - $item['discount'];
						$prijs = $prijs * $discount;
					}
				
				?>
				<p class="cartnumber"><?php echo $number->currency($prijs, 'EUR');?>
					<?php if($item['discount'] > 0):?>
						<br/><small>(<?php echo $item['discount'] * 100?>% korting)</small>
					<?php endif;?>
				</p>
				<?php $totalPrice += $prijs ?>
				<?php if(SENDCOST_PER_PRODUCT == 'true'):?>
				<?php $totalSend += $item['sendcost'];?>
				<?php endif; ?>
				
			</td>
			<td>
				<div class="delete"><small><a href="<?php echo HOME?>/winkel/removefromcart/<?php echo $item['id']?>/<?php echo $i?>">Verwijder</a></small></div>
			</td>
		</tr>
	<?php $i++; ?>
	<?php endforeach;?>
	<?php else: ?>
	<?php 	foreach($it as $item):
				$amount++;
			endforeach;
			
			$item = $it[0];
			?>
	<tr>
		<td><img src="<?php echo HOME . $item['thumb']?>" width="70px"></td>
		<td  style="text-align:left; padding-left:25px">
			<?php echo $item['name']?>
		</td>
		<td><b><?php echo $amount ?></b></td>
		<td>
			<?php $prijs = $item['price'] + ($item['price'] * $item['vat']); ?>
			<?php
			
				if($item['discount'] > 0){
					$discount = 1 - $item['discount'];
					$prijs = $prijs * $discount;
				}
			
			?>
			
			<p class="cartnumber"><?php echo $number->currency($prijs * $amount, 'EUR');?>
				<?php if($item['discount'] > 0):?>
					<br/><small>(<?php echo $item['discount'] * 100?>% korting)</small>
				<?php endif;?>
			</p>
			<?php $totalPrice += ($prijs * $amount) ?>
			<?php if(SENDCOST_PER_PRODUCT == 'true'):?>
			<?php $totalSend += ($item['sendcost'] * $amount);?>
			<?php endif; ?>
		</td>
		<td>
			<div class="delete"><small><a href="<?php echo HOME?>/winkel/removefromcart/<?php echo $item['id']?>">Verwijder</a></small></div>
		</td>
	</tr>
	<?php endif;?>
<?php endforeach?>
<?php

	if(SENDCOST_PER_PRODUCT == 'false'){
		$totalSend = SENDCOST;
	}

?>

	<tr>
		<td colspan="2" class="cartprice" style="border:0px"></td>
		<td class="cartlabel"><b>Lopend totaal:</b></td>
		<td class="cartprice"><p class="cartnumber">
			<?php echo $number->currency($totalPrice, 'EUR');?>
		</p></td>
		<td class="cartprice" style="border:0px"></td>
	</tr>

	<tr>
		<td colspan="2"  class="cartprice" style="border:0px"></td>
		<td class="cartlabel"><b>Verzendkosten:</b></td>
		<td class="cartprice"><p class="cartnumber">
			<?php echo $number->currency($totalSend, 'EUR');?>
		</p></td>
		<td class="cartprice" style="border:0px"></td>
	</tr>
	<tr>
		<td colspan="2" class="cartprice" style="border:0px"></td>
		<td class="cartlabel"><b>Totaal:</b></td>
		<td class="cartprice"><p class="cartnumber">
			<?php echo $number->currency($totalPrice + $totalSend, 'EUR');?>
		</p></td>
		<td class="cartprice" style="border:0px"></td>
	</tr>
</table>

<table style="text-align:right;margin-top:50px">
	<tr>
		<td style="border:0px">
			<a href="<?php echo HOME?>/winkel/login">
				<img src="<?php echo HOME?>/img/frontside/continuecart.jpg" />
			</a>
		</td>
	</tr>
</table>


<?php else: ?>
<table>
	<tr>
		<th>Uw winkelwagentje is leeg!<br/><br/>
			<a href="<?php echo HOME?>/">Bekijk onze nieuwste producten &raquo;</a><br/><br/>
		</th>
	</tr>
</table>	
<?php endif;?>
</div>