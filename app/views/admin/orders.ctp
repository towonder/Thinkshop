<div class="productform">
<h2><img src="<?php echo HOME?>/img/icons/orders.png"/> Orders</h2>
</div>

<table cellpadding="0" cellspacing="0" class="maintable_orders">
	<tr class="tablehead">
		<td width="80px"><p>Bedrag</p></td>
		<td width="100px"><p><?php echo $paginator->sort('Ordernummer', 'id'); ?></p></td>
		<td width="200px"><p>Klant</p></td>
		<td style="text-align:left" width="80px"><p><?php echo $paginator->sort('Datum', 'created'); ?></p></td>
		<td  style="text-align:left"><p style="margin:0px; margin-top:0px; margin-left:30px;">Acties</p></td>
	</tr>
	<?php if($amountOrders > AMOUNT_ON_PAGE):?>
	<tr class="tablefooter" style="height:10px">
		<td colspan="5" class="tablefooter" style="height:10px">			
			<div class="paginator_normal">
				<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
			</div>
		</td>
	</tr>
	<?php endif; ?>
	
	<tr class="altrow">
		<td colspan="5">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php foreach($orders as $order):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		
		if($order['Order']['paid'] == '0'){
			$tdclass = ' class="notpaid"';
		}else{
			$tdclass = ' class="paid"';
		}
	?>
	<?php $totaal = 0; $sendcost = 0; $totalboth = 0;?>
	<?php foreach($order['Product'] as $product):?>
	<?php 	$totaal += $product['price'];
			$totaal += $product['price'] * $product['vat'];
			
			if(SENDCOST_PER_PRODUCT == 'true'):
	 			$sendcost += $product['sendcost'];
	 			$totalboth += $product['price'] + ($product['price'] * $product['vat']) + $product['sendcost'];
			else:
				$sendcost = SENDCOST;
			endif;
	?>
	
	<?php endforeach;?>
	<?php if(SENDCOST_PER_PRODUCT == 'false'):?>
	<?php $totalboth = $totaal + SENDCOST ?>
	<?php endif;?>


	<tr<?php echo $class;?>>
		<td style="text-align:left" <?php echo $tdclass?>>
			<?php if($order['Order']['paid'] == '0'):?>
			<p><?php echo $number->currency($totalboth, 'EUR')?></p>
			<small>(Niet betaald)</small>
			<?php else: ?>
			<p><?php echo $number->currency($totalboth, 'EUR')?></p>
			<?php endif; ?>
		</td>
		<td style="text-align:center">
			<?php echo '#'. sprintf("%04d",$order['Order']['id']);?>
		</td>
		<td style="text-align:center">
			<div class="ordername">
				<?php
					$voornaam = strtolower($order['User']['firstname']);
					$achternaam = strtolower($order['User']['lastname']);
				?>
				
				<?php echo ucwords(substr($voornaam,0,1)) .". ". ucwords($achternaam); ?>
			</div>
		</td>
		<td>
			<?php $date = strtotime($order['Order']['created']);?>
			<small><?php echo date("d/m/y", $date)?></small>
		</td>
		<td>
			<div class="info"><small><a href="<?php echo HOME?>/admin/vieworder/<?php echo $order['Order']['id']?>">Bekijk</a></small></div>
			<?php if($order['Order']['paid'] == '0'):?>
			<div class="pay"><small><a href="<?php echo HOME?>/admin/orderpaid/<?php echo $order['Order']['id']?>">Wel betaald</a></small></div>
			<?php else: ?>
			<div class="pay"><small><a href="<?php echo HOME?>/admin/orderpaid/<?php echo $order['Order']['id']?>">Niet betaald</a></small></div>
			<?php endif;?>
		</td>
	</tr>
	<?php endforeach; ?>
	<tr class="altrow">
		<td colspan="5">&nbsp;</td>
	</tr>	
	<?php if($amountOrders > AMOUNT_ON_PAGE):?>
		<tr class="tablefooter" style="height:10px">
			<td colspan="5" class="tablefooter" style="height:10px">			
				<div class="paginator_normal">
					<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
				</div>
			</td>
		</tr>
		<?php endif; ?>
	
	
</table>