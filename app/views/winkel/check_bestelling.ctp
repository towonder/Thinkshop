<?php 	

	if($user['User']['gender'] == 'm'){
		$naam = 'Dhr. '. $user['User']['firstname'] .' '. $user['User']['lastname']; 
	}else{
		echo 'Mevr. '. $user['User']['firstname'] .' '. $user['User']['lastname'];
	}	
	
	$difinvoice = false;
	
	if(!empty($user['User']['invoiceaddress']) && !empty($user['User']['invoicezipcode']) && !empty($user['User']['invoicecity'])){
		$difinvoice = true;
	}
	
?>	
<?php $totalSend = 0; ?>

<div id="userdiv">
	<h2 style="width:600px;">Adresgegevens:</h2>
	<table>
		<tr>
			<td><b>Bezorgadres:</b></td>
			<td><b>Factuuradres:</b></td>
		</tr>
		<tr>
			<td><?php echo $naam; ?></td>
			<td><?php echo $naam; ?></td>
		</tr>
		<tr>
			<td><?php echo $user['User']['address']?></td>
			<?php if($difinvoice == true):?>
			<td><?php echo $user['User']['invoiceaddress']?></td>
			<?php else: ?>
			<td><?php echo $user['User']['address']?></td>
			<?php endif; ?>
		</tr>
		<tr>
			<td><?php echo $user['User']['zipcode'] .' '. $user['User']['city']?></td>
			<?php if($difinvoice == true):?>
			<td><?php echo $user['User']['invoicezipcode'] .' '. $user['User']['invoicecity']?></td>
			<?php else: ?>
			<td><?php echo $user['User']['zipcode'] .' '. $user['User']['city']?></td>
			<?php endif; ?>
		</tr>
		<tr>
			<td><?php echo $user['User']['country']?></td>
			<?php if($difinvoice == true):?>
			<td><?php echo $user['User']['invoicecountry']?></td>
			<?php else: ?>
			<td><?php echo $user['User']['country']?></td>
			<?php endif; ?>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<a href="<?php echo HOME?>/winkel/account/">Gegevens bijwerken &raquo;</a>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		
	</table>
</div>


<?php $totalPrice = 0;?>
<div id="cartdiv" style="margin-top:30px">
	<h2 style="width:600px;padding-left:30px">Winkelwagentje:</h2>
<?php if(!empty($cart)):?>
<table cellspacing="0" cellpadding="0">
	<tr>
		<th width="70px"></th>
		<th>Product</th>
		<th>Aantal</th>
		<th>Prijs</th>
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
	</tr>

	<tr>
		<td colspan="2"  class="cartprice" style="border:0px"></td>
		<td class="cartlabel"><b>Verzendkosten:</b></td>
		<td class="cartprice"><p class="cartnumber">
			<?php echo $number->currency($totalSend, 'EUR');?>
		</p></td>
	</tr>
	<tr>
		<td colspan="2" class="cartprice" style="border:0px"></td>
		<td class="cartlabel"><b>Totaal:</b></td>
		<td class="cartprice"><p class="cartnumber">
			<?php echo $number->currency($totalPrice + $totalSend, 'EUR');?>
		</p></td>
	</tr>
</table>

<table style="text-align:right;margin-top:50px">
	<tr>
		<td style="border:0px">
			<a href="<?php echo HOME?>/winkel/betalen">
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