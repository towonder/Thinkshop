<h2><img src="<?php echo HOME?>/img/icons/dashboard.png"/> <?php __('Overzicht')?></h2>

<div id="thinkshopoverview">
<div class="description_text"><?php __('Uw Thinkshop')?></div>

<table id="overviewtable">
	<tr>
	<td id="overview" valign="top" style="width:30%">
		<h4><?php __('Inhoud')?></h4>
		<table style="width:185px; height:130px; border-right:1px solid #f0a7bc;">
			<tr>
				<?php if($amountProducts > 1 || $amountProducts == 0):?>
				<td><p class="amount_number"><?php echo $amountProducts; ?></p></td><td><?php __('Producten')?></td>
				<?php else:?>
				<td><p class="amount_number"><?php echo $amountProducts; ?></p></td><td><?php __('Product')?></td>
				<?php endif;?>
			</tr>
			<tr>
				<?php if($amountCategories > 1 || $amountCategories == 0):?>
				<td><p class="amount_number"><?php echo $amountCategories; ?></p></td><td><?php __('Categorie&euml;n')?></td>
				<?php else:?>
				<td><p class="amount_number"><?php echo $amountCategories; ?></p></td><td><?php __('Categorie')?></td>
				<?php endif;?>				
			</tr>
			<tr>
				<?php if($amountPosts > 1 || $amountPosts == 0):?>
				<td><p class="amount_number"><?php echo $amountPosts; ?></p></td><td><?php __('Nieuwsberichten')?></td>
				<?php else:?>
				<td><p class="amount_number"><?php echo $amountPosts; ?></p></td><td><?php __('Nieuwsbericht')?></td>
				<?php endif;?>
				
			</tr>
			<tr>
				<?php if($amountPages > 1 || $amountPages == 0):?>
				<td><p class="amount_number"><?php echo $amountPages; ?></p></td><td><?php __('Pagina\'s')?></td>
				<?php else:?>
				<td><p class="amount_number"><?php echo $amountPages; ?></p></td><td><?php __('Pagina')?></td>
				<?php endif;?>
			</tr>
			
		</table>
	</td>

	<td id="actueel" valign="top" style="width:40%">
		<h4><?php __('Actueel')?></h4>
		<table style="width:90%; height:130px; border-right:1px solid #f0a7bc;" cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top"><p class="amount_order"><?php echo $amountOrders; ?></p></td>
			</tr>
			<tr>
				<td><small><?php __('Nieuwe orders sinds u laatst<br/> bent ingelogd')?>.</small></td>
			</tr>
		</table>
	
	</td>
	<td id="quarter" valign="top" style="width:30%">
		<h4><?php __('Dit kwartaal')?></h4>
		<table>
			<tr>
				<td><?php __('In')?>:</td>
				<td><p class="amount_number"><?php echo $number->currency($amountIn, CURRENCY)?></p></td>
			</tr>
			<tr>
				<td><?php __('Uit')?>:</td>
				<td><p class="amount_number"><?php echo $number->currency($amountOut, CURRENCY)?></p></td>
			</tr>
			<tr>
				<td></td>
				<td style="border-top:1px solid #f0a7bc"></td>
			</tr>
			<?php if($amountIn >= $amountOut):?>
				<td><?php __('Winst')?>:</td>
				<td><p class="amount_number"><?php echo $number->currency($amountIn - $amountOut, CURRENCY);?></p></td>
			<?php else: ?>
				<td><?php __('Verlies')?>:</td>
				<td><p class="amount_number"><?php echo $number->currency($amountOut - $amountIn, CURRENCY);?></p></td>
			<?php endif;?>
		</table>
	</td>
</tr>
</table>
</div>

<?php if(!empty($orders)):?>
<div class="overviewmedium" id="ord">
	<div class="description_text"><?php __('Nieuwste orders')?></div>
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
				<p style="color:#e9265e;font-style:italic"><?php __('Niet betaald')?></p>
				<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td colspan="3" class="alttable_bottom"><small><a href="<?php echo HOME?>/admin/orders"><?php __('Bekijk alle orders')?> &raquo;</a></small></td>
		</tr>
	</table>
</div>
<?php endif;?>

<div class="overviewsmall" id="prod">
	<div class="description_text"><?php __('Nieuwste producten')?></div>
	<table cellpadding='0' cellspacing='0'>
		<?php $i = 1;?>
		<?php foreach($products as $product):
		
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="alttable"';
				}?>
		<tr <?php echo $class?>>
			<td><a href="<?php echo HOME?>/admin/editproduct/<?php echo $product['Product']['id']?>"><?php echo ucwords($product['Product']['name']);?></a></td>
			<td><?php echo $number->currency($product['Product']['price'], CURRENCY);?></td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td colspan="3" class="alttable_bottom"><small><a href="<?php echo HOME?>/admin/products"><?php __('Bekijk alle producten')?> &raquo;</a></small></td>
		</tr>
	</table>
</div>
<?php if($ga == true):?>
<div class="overviewmedium" id="stats">
	<div class="description_text"><?php __('Statistieken')?></div>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="3" id="totalvisits"><?php __('Bezoeken deze maand')?>: <p class="amount_visits"><?php echo $totalVisits?></p></td>
		</tr>
		<tr>
			<td colspan="3"><small><?php __('Afkomstig van')?>:</small></td>
		</tr>
		<tr>
			<td width="33%"><p class="amount_percentage"><?php echo $totalDirectVisits?>%</p></td>
			<td width="33%"><p class="amount_percentage"><?php echo $totalSearchVisits?>%</p></td>
			<td><p class="amount_percentage"><?php echo $totalReferVisits?>%</p></td>
		</tr>
		<tr>
			<td><small><?php __('Direct verkeer')?></small></td>
			<td><small><?php __('Zoekmachines')?></small></td>
			<td><small><?php __('Links')?></small></td>
		</tr>
	</table>
	<div id="galink" class="alttable_bottom">
		<a href="https://www.google.com/analytics/reporting/?reset=1&id=<?php echo $gaid?>"><?php __('Ga naar Google Analytics')?> &raquo;</a>
	</div>
</div>
<?php endif; ?>
<?php if(!empty($posts)):?>
<div class="overviewsmall" id="pos">
	<div class="description_text"><?php __('Nieuwste berichten')?></div>
	<table cellpadding='0' cellspacing='0'>
		<?php $i = 1;?>
		<?php foreach($posts as $post):
		
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="alttable"';
				}?>
		<tr <?php echo $class?>>
			<td><a href="<?php echo HOME?>/admin/editpost/<?php echo $post['Post']['id']?>"><?php echo ucwords($post['Post']['title']);?></a></td>
			<td><?php echo date('d-m-Y', strtotime($post['Post']['created']));?></td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td colspan="3" class="alttable_bottom"><small><a href="<?php echo HOME?>/admin/news"><?php __('Bekijk alle nieuwsberichten')?> &raquo;</a></small></td>
		</tr>
	</table>
</div>
<?php endif;?>
