<?php

	$invoice = false;

	if(!empty($user['invoiceaddress']) && !empty($user['invoicezipcode']) && !empty($user['invoicecity']) && !empty($user['invoicecountry'])){
		$invoice = true;
	}

// cellspacing="0" cellpadding="0"
?>

<div id="accountinfo">
	<table>
		<tr>
			<td>
				<p class="ordertitle"><?php echo $user['firstname'] .' '. $user['lastname']?></p>
				<div class="edit"><a href="<?php echo HOME?>/winkel/accountBewerken">Bewerken</a></div>
			</td>
			<td style="text-align:right"><a href="<?php echo HOME?>/winkel/logout">Logout</a></td>
			
		</tr>
		<tr>
			<td class="accounttitle"><b>Bezorgadres:</b></td>
			<td class="accounttitle"><b>Factuuradres:</b></td>
		</tr>
		<tr>
			<td class="accountaddress">
				<?php echo $user['address']?><br/>
				<?php echo $user['zipcode'] .' '. $user['city']?><br/>
				<?php echo $user['country']?>
			</td>
			<?php if($invoice == true):?>
			<td class="accountaddress">
				<?php echo $user['invoiceaddress']?><br/>
				<?php echo $user['invoicezipcode'] .' '. $user['invoicecity']?><br/>
				<?php echo $user['invoicecountry']?>
			</td>
			<?php else: ?>
			<td class="accountaddress">
				<?php echo $user['address']?><br/>
				<?php echo $user['zipcode'] .' '. $user['city']?><br/>
				<?php echo $user['country']?>
			</td>
			<?php endif;?>
		</tr>
		<tr>
			<td>&nbsp;<br/><br/></td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" style="width:530px">
		<tr>
			<td colspan="3"><p class="ordertitle">Uw bestellingen</p></td>
		</tr>
		<?php if(!empty($orders)):?>
		<?php foreach($orders as $order):?>
		<?php $totalorder = 0; ?>
		
		<tr>
			<td class="ordertop"><?php echo date('d-m-Y', strtotime($order['Order']['created']));?></td>
			<td class="ordertop">Ordernummer: <?php echo '#'. sprintf("%04d",$order['Order']['id']);?></td>
			<td class="ordertop" style="text-align:right">
				<?php if($order['Order']['paid'] == '1'):?>
				<small>betaald</small>
				<?php else: ?>
				<small class="alarm">nog niet betaald!</small>
				<?php endif;?>
			</td>
		</tr>
		<?php foreach($order['Product'] as $product):?>
		<tr>
			<td class="orderproduct"><img src="<?php echo HOME . $product['Image']['thumb']?>" width="70px" /></td>
			<td class="orderproduct"><?php echo $product['name']?></td>
			<?php $prijs = $product['price'] + ($product['price'] * $product['vat']);?>
			<?php $totalorder += $prijs; ?>
			<td class="orderproduct"><?php echo $number->currency($prijs, 'EUR');?></td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td class="orderproduct"></td>
			<td class="orderproduct" style="text-align:right;">Totaal:</td>
			<td class="orderproduct" id="totalorder"><?php echo $number->currency($totalorder, 'EUR');?></td>
		</tr>
		<tr>
			<td class="orderbottom" colspan="3">&nbsp;</td>
		</tr>
		<?php endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="2">U heeft nog geen bestellingen bij <?php echo WEBSITE_TITLE ?> gedaan.</td>
		</tr>
		<?php endif;?>
	</table>
		
</div>