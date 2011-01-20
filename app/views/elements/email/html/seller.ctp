<?php 	

$totalboth = 0;
$totaal = 0;
$sendcost = 0;
$totalVAT = 0;

	foreach($products as $product):

		$prijs = $product['Product']['price'] + ($product['Product']['price'] * $product['Product']['vat']);
		if($product['Product']['discount'] > 0){
			$discount = 1 - $product['Product']['discount'];
			$prijs = $prijs * $discount;
		}
		
		$totaal += $prijs;
		$sendcost += $product['Product']['sendcost'];
		
		if(SENDCOST_PER_PRODUCT == 'true'):
			$totalboth += $prijs + $product['Product']['sendcost'];
		else:
			$totalboth += $prijs;
		endif;

	endforeach;
	
	if(SENDCOST_PER_PRODUCT == 'false'){
		$sendcost = 0;
		$sendcost = SENDCOST;
		$totalboth += SENDCOST;
	}
	
?>
<style>

	body{
		background-color:#C6C5B7;
		position:relative;
	}
	
	a{
		color:#e9265e;
	}
	
	table{
		background-color:#f5f5f5;
		width:490px;
		position:absolute;
		padding:30px;
		padding-right:10px;
		margin-bottom:10px;
		top:20px;
		left:30px;
	}
	
	table table{
		position:relative;
		top:0px;
		left:0px;
		padding:0px;
	}

	.order_number{
		font-family:'Georgia', 'Times';
		font-style:italic;
		font-weight:normal;
		font-size:16px;
		color:#e9265e;
	}
	
	.bestelling{
		font-size:16px;
		font-family:'Georgia','Times';
		color:#555555;
	}

</style>

<table>
		<tr>
			<td colspan="3" style="font-size:23px;font-family:'Georgia','Times';color:#555555;">
				Er is een order geplaatst via <?php echo WEBSITE_TITLE?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<p>Klant: <?php echo $order['User']['firstname'] .' '. $order['User']['lastname']?></p>
			<p>Email: <a href="mailto:<?php echo $order['User']['email']?>"><?php echo $order['User']['email']?></a></p>
			</td>
			<td></td>
		</tr>
		<tr>
			
			<td width="100px" style="text-align:left;" valign="top"><p><b>Ordernummer:</b><br/>
				<?php echo '#'. sprintf("%04d",$order['Order']['id']);?></p>
			</td>			
			<td valign="top"><p style="margin-left:50px;">
				<?php if(!empty($order['User']['invoiceaddress'])):?>
				<b>Bezorgadres:</b><br/>
				<?php else: ?>
				<b>Bezorg & factuuradres:</b><br/>
				<?php endif; ?>
				<?php echo $order['User']['address'] .'<br/>'?>
				<?php echo $order['User']['zipcode'] .' '. strtoupper($order['User']['city'])?><br/>
				<?php echo $order['User']['country']?></p>
			</td>
			<td valign="top">
				<?php if(!empty($order['User']['invoiceaddress'])):?>
				<p style="text-align:right"><b>Factuuradres:</b><br/>
				<?php echo $order['User']['invoiceaddress'] .'<br/>'?>
				<?php echo $order['User']['invoicezipcode'] .' '. strtoupper($order['User']['invoicecity'])?><br/>
				<?php echo $order['User']['invoicecountry']?></p>
				<?php endif;?>
			</td>	
		</tr>
		<tr>
			<td colspan="3"><p class="bestelling">Bestelling:</p></td>
		</tr>
		<tr>
			<td colspan="3" width="100%">
				<table cellpadding="0" cellspacing="0" style="width:540px">
					<tr>
						<th></th
						<th style="text-align:center">Product</th>
						<th style="text-align:center">Prijs</th>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<?php foreach($products as $product):?>
					<tr>	
						<td>
							<img src="<?php echo HOME . $product['Image']['thumb']?>" width="70px" />
						</td>
						<td style="text-align:center">
							<?php echo $product['Product']['name']?>
							<?php if(!empty($product['Options'])):?>
							<br/>
							<?php foreach($product['Options'] as $option):?>
								<?php echo '<small>'. $option['term'] .': '. $option['value'] .'</small><br/>'?>
							<?php endforeach; ?>
							<?php endif; ?>
						</td>
						<td   style="text-align:center"><p>
							<?php $prijs = $product['Product']['price'] + ($product['Product']['price'] * $product['Product']['vat']); ?>
							<?php
								if($product['Product']['discount'] > 0){
									$discount = 1 - $product['Product']['discount'];
									$prijs = $prijs * $discount;
								}
							?>
							<?php echo $number->currency($prijs, 'EUR');?>
							<?php if($product['Product']['discount'] > 0):?>
								<br/><small>(<?php echo $product['Product']['discount'] * 100?>% Korting)</small>
							<?php endif;?>
							</p>
						</td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					
					<tr>
						<td class="lopend"></td>
						<td class="lopend" style="text-align:right;padding-right:10px"><p class="tabletext">Lopend totaal:</p></td>
						<td class="lopend" style="text-align:center;border-top:1px dotted #555"><p><?php echo $number->currency($totaal, 'EUR');?></p></td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;padding-right:10px"><p class="tabletext">Verzendkosten:</p></td>
						<td class="bedrag" style="text-align:center;border-top:1px dotted #555"><p><?php echo $number->currency($sendcost, 'EUR');?></p></td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:right;padding-right:10px"><p class="tabletext">Totaal:</p></td>
						<td class="allestotaal" style="text-align:center;border-top:1px solid #555"><p><?php echo $number->currency($totalboth, 'EUR')?></p></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">
			<b>Betaalwijze:</b><br/>
			<?php if($order['Order']['paid'] == 0):?>
			Overschrijving
			<?php else: ?>
			iDeal
			<?php endif;?>
			</td>
		</tr>
		<?php if($order['Order']['paid'] == 0):?>
		<tr>
			<td colspan="3">
				De klant is verzocht om het volledige bedrag (<?php echo $number->currency($totalboth, 'EUR')?>) over te maken.<br/><br/>
			</td>
		</tr>
		<?php endif;?>
		
		<tr>
			<td colspan="3">
				<a href="<?php echo HOME?>/admin/vieworder/<?php echo $order['Order']['id']?>">Bekijk de order in de administratie &raquo;</a><br/><br/>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				Groeten,<br/>
				Het systeem ;)
			</td>
		</tr>
</table>
