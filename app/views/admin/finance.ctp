<?php

	$totalmoney = 0;
	$totalcost = 0;
	$costbtw = 0;
	$costretail = 0;
/*	
	foreach($orders as $order){
		foreach($order['Product'] as $product){
			$totalmoney += $product['price'];
		}
	}	
*/
?>
<div class="productform" style="margin-bottom:30px">
<h2><img src="<?php echo HOME?>/img/icons/finance.png"/> <?php __('In & Uit')?></h2>
</div>


<table cellpadding="0" cellspacing="0" class="maintable_orders" style="margin-bottom:0px; padding-bottom:15px">
	<tr class="tablehead">
		<td style="text-align:center" class="next"><p><a href="<?php echo HOME?>/admin/finance/<?php echo $prevkwartaal .'/'.$prevjaar?>">&laquo;</a></p></td>
		<td style="text-align:center"><h3><?php __('Kwartaal')?> <?php echo $kwartaal .', '. $jaar?></h3></td>
		<td style="text-align:center" class="next"><p><a href="<?php echo HOME?>/admin/finance/<?php echo $nextkwartaal .'/'.$nextjaar?>">&raquo;</a></p></td>
	</tr>
</table>


<table cellpadding="0" cellspacing="0" class="maintable_inout" style="margin-right:17px">
	<tr class="tablehead">
		<td colspan="3"><h3><?php __('In')?></h3></td>
	</tr>
	<tr>
		<th width="100px"><?php __('Besteld op')?></th>
		<th width="100px"><?php __('Product')?></th>
		<th width="150px"><?php __('Prijs')?></th>
	</tr>
	<tr class="altrow">
		<td colspan="4">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php foreach($orders as $order):?>
		<?php $date = strtotime($order['Order']['created'])?>
		<?php foreach($order['Product'] as $product):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>

	<tr<?php echo $class;?>>
		<td style="text-align:left">
			<small><p style="margin-left:15px"><?php echo date('d-m-Y', $date);?></p></small>
		</td>
		<td style="text-align:left">
			<small><p style="margin-left:15px"><?php echo $product['name']?></p></small>
		</td>
		<td style="text-align:right;">
			<p style="margin-right:15px"><?php echo $number->currency($product['price'], CURRENCY);?></p>
			<?php $totalmoney += $product['price'];?>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php endforeach; ?>
	<tr class="altrow">
		<td>&nbsp;</td>
		<td style="text-align:right"><?php __('totaal')?>:</td>
		<td style="border-top:2px solid #999; text-align:right">
			<p style="margin-right:15px"><?php echo $number->currency($totalmoney, CURRENCY);?></p>
		</td>
	</tr>
</table>

<table cellpadding="0" cellspacing="0" class="maintable_inout">
	<tr class="tablehead">
		<td colspan="2"><h3><?php __('Uit')?></h3></td>
		<td style="text-align:right"><a href="<?php echo HOME?>/admin/addcost/" class="addcostbox" style="margin-right:10px;text-decoration:none"><small><img src="<?php echo HOME?>/img/icons/new.png" width="10px"> <?php __('Nieuwe kostenpost')?></small></a></td>
	</tr>
	<tr>
		<th width="100px"><?php __('Gekocht op')?></th>
		<th width="100px"><?php __('Product')?></th>
		<th width="150px"><?php __('Prijs')?></th>
	</tr>
	<tr class="altrow">
		<td colspan="4">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php foreach($costs as $cost):
	
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
		<?php $date = strtotime($cost['Cost']['created'])?>
		

	<tr<?php echo $class;?>>
		<td style="text-align:left">
			<small><p style="margin-left:15px"><?php echo date('d-m-Y', $date);?></p></small>
		</td>
		<td style="text-align:left">
			<small><p style="margin-left:15px"><?php echo $cost['Cost']['naam']?></p></small>
		</td>
		<td style="text-align:right;">
			<p style="margin-right:15px"><?php echo $number->currency($cost['Cost']['prijs'], CURRENCY);?></p>
			<?php 

				$totalcost += $cost['Cost']['prijs'];

				if($cost['Cost']['btw'] == 'hoog'){
					$costbtw += ($cost['Cost']['prijs'] * 0.19);
					$costretail += ($cost['Cost']['prijs'] * 0.81);
				}else if($cost['Cost']['btw'] == 'laag'){
					$costbtw += ($cost['Cost']['prijs'] * 0.06);
					$costretail += ($cost['Cost']['prijs'] * 0.94);
				}
			
			
			
			?>
			
		</td>
	</tr>
	<?php endforeach; ?>
	<tr class="altrow">
		<td>&nbsp;</td>
		<td style="text-align:right"><?php __('totaal')?>:</td>
		<td style="border-top:2px solid #999; text-align:right">
			<p style="margin-right:15px"><?php echo $number->currency($totalcost, CURRENCY);?></p>
		</td>
	</tr>
</table>
<br/>
<table cellpadding="0" cellspacing="0" class="maintable_inoutfinal">
	<tr>
		<th style="background-color:#e9265e; height:30px"></th>
		<th width="180px" style="background-color:#e9265e;"><?php __('Btw')?></th>
		<th width="180px" style="background-color:#e9265e;"><?php __('Totaal exclusief btw')?></th>
		<th width="180px" style="background-color:#e9265e;"><?php __('Totaal inclusief btw')?></th>
	</tr>
	<tr>
		<td colspan="4" style="height:30px">&nbsp;</td>
	</tr>
	<tr style="text-align:center; height:30px" class="altrow">
		<td>In:</td>
		<td><?php echo $number->currency(($totalmoney * 0.19), CURRENCY); ?></td>
		<td><?php echo $number->currency(($totalmoney * 0.81), CURRENCY);?></td>
		<td><?php echo $number->currency($totalmoney, 'EUR');?></td>
		
		
	</tr>
	<tr style="text-align:center; height:30px">
		<td>Uit:</td>
		<td><?php echo $number->currency($costbtw, 'EUR');?></td>
		<td><?php echo $number->currency($costretail, 'EUR');?></td>
		<td><?php echo $number->currency($totalcost, 'EUR')?></td>
		
	</tr>
	<tr class="altrow" style="text-align:left;height:80px">
		<td></td>
		<?php if($totalmoney > $totalcost):?>
		<td style="border-top:2px solid #777"><small><?php __('BTW BETALEN')?>:</small><br/>
			<p style="margin-left:65px"><?php echo $number->currency(($totalmoney * 0.19) - $costbtw, CURRENCY);?></p>
		</td>
		<td style="border-top:2px solid #777"><small><?php __('WINST')?>:</small><br/>
			<p style="margin-left:65px"><?php echo $number->currency(($totalmoney * 0.81) - $costretail, CURRENCY);?></p>
		</td>
		<?php elseif($totalcost > $totalmoney):?>
		<td style="border-top:2px solid #777"><small><?php __('BTW TERUG')?>:</small></br>
			<p style="margin-left:65px"><?php echo $number->currency($costbtw - ($totalmoney * 0.19), CURRENCY);?></p>
		</td>
		<td style="border-top:2px solid #777"><small><?php __('VERLIES')?>:</small><br/>
			<p style="margin-left:65px"><?php echo $number->currency($costretail - ($totalmoney * 0.81), CURRENCY);?></p>
		</td>
		<?php else:?>
		<td style="border-top:2px solid #777"></td>
		<td style="border-top:2px solid #777"></td>
		<?php endif;?>
		<td>
		</td>
	</tr>
		

	</tr>
</table>