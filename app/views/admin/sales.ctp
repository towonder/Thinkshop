<?php

	$totalmoney = 0;
	
	foreach($orders as $order){
		foreach($order['Product'] as $product){
			$totalmoney += $product['price'];
		}
	}	
?>
<div class="productform" style="margin-bottom:30px">
<h2><?php __('Verkopen')?></h2>
</div>

<table cellpadding="0" cellspacing="0" class="maintable_orders">
	<tr class="tablehead">
		<td width="200px"><p><?php __('Product')?></p></td>
		<td width="50px"><p><?php __('Bestellingen')?></p></td>
		<td width="50px" style="text-align:left"><p><?php __('Prijs ex.')?></p></td>
		<td width="50px" style="text-align:left"><p><?php __('BTW')?></p></td>
		<td width="50px"><p><?php __('Totaalprijs')?></p></td>
	</tr>
	<tr class="altrow">
		<td colspan="4">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php foreach($products as $product):
		if(!empty($product['Order'])):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		$thisprodnum = 0;
	?>

	<tr<?php echo $class;?>>
		<td style="text-align:left">
			<p style="margin-left:15px"><?php echo $product['Product']['name']?></p>
		</td>
		<td style="text-align:center">
			<?
				foreach($product['Order'] as $order){
					if($order['paid'] == '1'){
						$thisprodnum++;
					};
				}
				echo $thisprodnum;
			?>
		</td>
		<td style="text-align:left">
			<?php echo $number->currency(($thisprodnum * $product['Product']['price'])*0.81, 'EUR')?>
		</td>
		<td style="text-align:left">
			<?php echo $number->currency(($thisprodnum * $product['Product']['price'])*0.19, 'EUR')?>
		</td>
		<td  style="text-align:center">
			<?php echo $number->currency($thisprodnum * $product['Product']['price'], 'EUR');?>
		</td>
	</tr>
	<?php endif;?>
	<?php endforeach; ?>
	<tr class="altrow">
		<td colspan="2">&nbsp;</td>
		<td style="border-top:2px solid #999; text-align:left">
			<?php echo $number->currency($totalmoney * 0.81, 'EUR');?>
		</td>
		<td style="border-top:2px solid #999; text-align:left">
			<?php echo $number->currency($totalmoney * 0.19, 'EUR');?>
		</td>
		<td style="border-top:2px solid #333; height:40px; text-align:center">
			<?php echo $number->currency($totalmoney, 'EUR')?>
		</td>
	</tr>
	
</table>