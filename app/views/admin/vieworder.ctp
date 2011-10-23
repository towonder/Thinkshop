<?php 	

$totalboth = 0;
$totaal = 0;
$sendcost = 0;
$totalVAT = 0;

	foreach($products as $product):

		$prijs = $product['Product']['price'] + ($product['Product']['price'] * $product['Product']['vat']);
		$totaal += $product['Product']['price'];
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

<h2><?php __('Bekijk order')?></h2>

<div id="orderdiv">
	<div id="printbuttons">
		<a href="<?php echo HOME?>/admin/printorder/<?php echo $order['Order']['id']?>" target="_blank">
			<img src="<?php echo HOME?>/img/icons/print.png" alt="Print versie" title="Print versie"/>
		</a>
	</div>
	<table>
		<tr>
			<td><small><p class="amount_number"><?php echo $number->currency($totalboth, CURRENCY);?></p></td>
			<td><p class="ordertitle">
					<?php echo $order['User']['firstname'] .' '. $order['User']['lastname']?><br/>
<small><a href="mailto:<?php echo $order['User']['email']?>">(<?php echo $order['User']['email'] ?>)</a></small>
				</p>
			</td>
			<td>
				<?php if($order['Order']['paid'] == '0'):?>
				<p class="ordernotpaid"><?php __('Nog niet betaald')?>!</p>
				<?php else:?>
				<p class="orderpaid"><?php __('Betaald')?>.</p>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td width="100px" style="text-align:center;" class="orderpad" valign="top"><small><?php __('Ordernummer')?></small>
				<p class="order_number"><?php echo '#'. sprintf("%04d",$order['Order']['id']);?></p>
			</td>			
			<td valign="top" class="orderpad"><p style="margin-left:50px;">
				<?php if(!empty($order['User']['invoiceaddress'])):?>
				<b><?php __('Bezorgadres')?>:</b><br/>
				<?php else: ?>
				<b><?php __('Bezorg & factuuradres')?>:</b><br/>
				<?php endif; ?>
				<?php echo $order['User']['address'] .'<br/>'?>
				<?php echo $order['User']['zipcode'] .' '. strtoupper($order['User']['city'])?><br/>
				<?php echo $order['User']['country']?></p>
			</td>
			<td valign="top" class="orderpad">
				<?php if(!empty($order['User']['invoiceaddress'])):?>
				<p style="text-align:right"><b><?php __('Factuuradres')?>:</b><br/>
				<?php echo $order['User']['invoiceaddress'] .'<br/>'?>
				<?php echo $order['User']['invoicezipcode'] .' '. strtoupper($order['User']['invoicecity'])?><br/>
				<?php echo $order['User']['invoicecountry']?></p>
				<?php endif;?>
			</td>	
		</tr>
		<tr>
			<td colspan="3"><p class="bestelling"><?php __('Bestelling')?>:</p></td>
		</tr>
		<tr>
			<td colspan="3" width="100%">
				<table cellpadding="0" cellspacing="0" style="width:540px">
					<tr>
						<th></th
						<th>Product</th>
						<th style="text-align:center"><?php __('Prijs')?> <br/><small>(<?php __('exclusief btw')?>)</small></th>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<?php foreach($products as $product):?>
					<tr>	
						<td>
							<img src="<?php echo HOME . $product['Image']['thumb']?>" width="70px" />
						</td>
						<td>
							<?php echo $product['Product']['name']?>
							<?php if(!empty($product['Options'])):?>
							<br/>
							<?php foreach($product['Options'] as $option):?>
								<?php echo '<small>'. $option['term'] .': '. $option['value'] .'</small><br/>'?>
							<?php endforeach; ?>
							<?php endif; ?>
						</td>
						<td  class="bedrag"><p style="margin-right:20px;padding-top:10px;padding-bottom:10px">
							<?php $prijs = $product['Product']['price']; ?>
							<?php echo $number->currency($prijs, CURRENCY);?></p>
							<?php $totalVAT += ($product['Product']['price'] * $product['Product']['vat']);?>
						</td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					
					<tr>
						<td class="lopend"></td>
						<td class="lopend" style="text-align:left"><p class="tabletext"><?php __('Lopend totaal')?>:</p></td>
						<td class="lopend"><p style="margin-right:20px;padding-top:10px;padding-bottom:10px"><?php echo $number->currency($totaal, CURRENCY);?></p></td>
					</tr>
					<tr>
						<td></td>
						<td><p class="tabletext"><?php __('BTW')?>:</p></td>
						<td class="bedrag"><p style="margin-right:20px;adding-top:10px;padding-bottom:10px"><?php echo $number->currency($totalVAT, CURRENCY);?></p></td>
					</tr>
					<tr>
						<td></td>
						<td><p class="tabletext"><?php __('Verzendkosten')?>:</p></td>
						<td class="bedrag"><p style="margin-right:20px;padding-top:10px;padding-bottom:10px"><?php echo $number->currency($sendcost, CURRENCY);?></p></td>
					</tr>
					<tr>
						<td></td>
						<td><p class="tabletext"><?php __('Totaal')?>:</p></td>
						<td class="allestotaal"><p style="margin-right:20px;padding-top:10px;padding-bottom:10px"><?php echo $number->currency($totalboth, CURRENCY)?></p></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>