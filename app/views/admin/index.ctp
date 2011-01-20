<h2><img src="<?php echo HOME?>/img/icons/dashboard.png"/> Overzicht</h2>

<div id="thinkshopoverview">
<div class="description_text">Uw Thinkshop</div>

<table id="overviewtable" style="width:100%">
	<tr>
	<td id="overview" valign="top" style="width:30%">
		<h4>Inhoud</h4>
		<table style="width:185px; height:130px; border-right:1px solid #f0a7bc;">
			<tr>
				<?php if($amountProducts > 1 || $amountProducts == 0):?>
				<td><p class="amount_number"><?php echo $amountProducts; ?></p></td><td>Producten</td>
				<?php else:?>
				<td><p class="amount_number"><?php echo $amountProducts; ?></p></td><td>Product</td>
				<?php endif;?>
			</tr>
			<tr>
				<?php if($amountCategories > 1 || $amountCategories == 0):?>
				<td><p class="amount_number"><?php echo $amountCategories; ?></p></td><td>Categorie&euml;n</td>
				<?php else:?>
				<td><p class="amount_number"><?php echo $amountCategories; ?></p></td><td>Categorie</td>
				<?php endif;?>				
			</tr>
			<tr>
				<?php if($amountPosts > 1 || $amountPosts == 0):?>
				<td><p class="amount_number"><?php echo $amountPosts; ?></p></td><td>Nieuwsberichten</td>
				<?php else:?>
				<td><p class="amount_number"><?php echo $amountPosts; ?></p></td><td>Nieuwsbericht</td>
				<?php endif;?>
				
			</tr>
			<tr>
				<?php if($amountPages > 1 || $amountPages == 0):?>
				<td><p class="amount_number"><?php echo $amountPages; ?></p></td><td>Pagina's</td>
				<?php else:?>
				<td><p class="amount_number"><?php echo $amountPages; ?></p></td><td>Pagina</td>
				<?php endif;?>
			</tr>
			
		</table>
	</td>

	<td id="actueel" valign="top" style="width:40%">
		<h4>Actueel</h4>
		<table style="width:90%; height:130px; border-right:1px solid #f0a7bc;" cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top"><p class="amount_order"><?php echo $amountOrders; ?></p></td>
			</tr>
			<tr>
				<td><small>Nieuwe orders sinds u laatst<br/> bent ingelogd.</small></td>
			</tr>
		</table>
	
	</td>
	<td id="quarter" valign="top" style="width:30%">
		<h4>Dit kwartaal</h4>
		<table>
			<tr>
				<td>In:</td>
				<td><p class="amount_number"><?php echo $number->currency($amountIn, 'EUR')?></p></td>
			</tr>
			<tr>
				<td>Uit:</td>
				<td><p class="amount_number"><?php echo $number->currency($amountOut, 'EUR')?></p></td>
			</tr>
			<tr>
				<td></td>
				<td style="border-top:1px solid #f0a7bc"></td>
			</tr>
			<?php if($amountIn >= $amountOut):?>
				<td>Winst:</td>
				<td><p class="amount_number"><?php echo $number->currency($amountIn - $amountOut, 'EUR');?></p></td>
			<?php else: ?>
				<td>Verlies:</td>
				<td><p class="amount_number"><?php echo $number->currency($amountOut - $amountIn, 'EUR');?></p></td>
			<?php endif;?>
		</table>
	</td>
</tr>
</table>
</div>
<div class="overviewalgemeen">
<?php if(!empty($orders)):?>
<div class="overviewmedium" id="ord">
	<div class="description_text">Nieuwste orders</div>
	<table cellpadding='0' cellspacing='0'>
		<?php $i = 1;?>
		<?php foreach($orders as $order):
		
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="alttable"';
				}?>
		<tr <?php echo $class?>>
			<td><?php echo ucwords($order['User']['firstname'] .' '. $order['User']['lastname'])?></td>
			<td><?php echo date('d-m-Y', strtotime($order['Order']['created']));?></td>
			<td>
				<?php if($order['Order']['paid'] == '1'):?>
				<p>Betaald</p>
				<?php else:?>
				<p style="color:#e9265e;font-style:italic">Niet betaald</p>
				<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td colspan="3" class="alttable_bottom"><small><a href="<?php echo HOME?>/admin/orders">Bekijk alle orders &raquo;</a></small></td>
		</tr>
	</table>
</div>
<?php endif;?>

<?php if(!empty($products)):?>
<div class="overviewsmall" id="prod">
	<div class="description_text">Nieuwste producten</div>
	<table cellpadding='0' cellspacing='0'>
		<?php $i = 1;?>
		<?php foreach($products as $product):
		
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="alttable"';
				}?>
		<tr <?php echo $class?>>
			<td><?php echo ucwords($product['Product']['name']);?></td>
			<td><?php echo $number->currency($product['Product']['price'], 'EUR');?></td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td colspan="3" class="alttable_bottom"><small><a href="<?php echo HOME?>/admin/products">Bekijk alle producten &raquo;</a></small></td>
		</tr>
	</table>
</div>
<?php endif; ?>
<?php if($ga == true):?>
<div class="overviewmedium" id="stats">
	<div class="description_text">Statistieken</div>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="3" id="totalvisits">Bezoeken deze maand: <p class="amount_visits"><?php echo $totalVisits?></p></td>
		</tr>
		<tr>
			<td colspan="3"><small>Afkomstig van:</small></td>
		</tr>
		<tr>
			<td width="33%"><p class="amount_percentage"><?php echo $totalDirectVisits?>%</p></td>
			<td width="33%"><p class="amount_percentage"><?php echo $totalSearchVisits?>%</p></td>
			<td><p class="amount_percentage"><?php echo $totalReferVisits?>%</p></td>
		</tr>
		<tr>
			<td><small>Direct verkeer</small></td>
			<td><small>Zoekmachines</small></td>
			<td><small>Links</small></td>
		</tr>
	</table>
	<div id="galink" class="alttable_bottom">
		<a href="https://www.google.com/analytics/reporting/?reset=1&id=<?php echo $gaid?>">Ga naar Google Analytics &raquo;</a>
	</div>
</div>
<?php endif; ?>
<?php if(!empty($posts)):?>
<div class="overviewsmall" id="pos">
	<div class="description_text">Nieuwste berichten</div>
	<table cellpadding='0' cellspacing='0'>
		<?php $i = 1;?>
		<?php foreach($posts as $post):
		
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="alttable"';
				}?>
		<tr <?php echo $class?>>
			<td><?php echo ucwords($post['Post']['title']);?></td>
			<td><?php echo date('d-m-Y', strtotime($post['Post']['created']));?></td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td colspan="3" class="alttable_bottom"><small><a href="<?php echo HOME?>/admin/news">Bekijk alle nieuwsberichten &raquo;</a></small></td>
		</tr>
	</table>
</div>
<?php endif;?>
</div>