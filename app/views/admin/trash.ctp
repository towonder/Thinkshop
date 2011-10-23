<div class="productform">
<h2><img src="<?php echo HOME?>/img/icons/trash.png"/> <?php __('Prullenbak')?></h2>
</div>

<table cellpadding="0" cellspacing="0" class="maintable">
	<tr class="tablehead">
		<td colspan="3"><h3><?php __('Prullenbak')?></h3></td>
	</tr>
	<?php if($amount > AMOUNT_ON_PAGE):?>
	<tr class="tablefooter">
		<td colspan="4" class="tablefooter">			
			<div class="paginator_normal">
				<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
			</div>
		</td>
	</tr>
	<?php endif; ?>
	<tr class="tablehead">
		<th width="130px"></th>
		<th><?php __('Productnaam')?>:</th>
		<th width="400px"><?php __('Acties')?>:</th>
	</tr>
	<tr class="altrow">
		<td colspan="3">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php if(!empty($products)):?>
	<?php foreach($products as $product):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
		<tr <?php echo $class?>>
			<td style="text-align:left;width:120px">
			<?php if(!empty($product['Image']['thumb'])):?>
			<img src="<?php echo HOME . $product['Image']['thumb']?>" height="70px" style="margin-left:10px;padding-bottom:5px;padding-top:5px"/>
		<?php else: ?>
			<img src="<?php echo HOME?>/img/no_picture_thumb.png" height="70px" style="margin-left:10px;padding-bottom:5px;padding-top:5px"/>
		<?php endif;?>
			</td>
	
	<?php if($product['Product']['concept'] == 1):?>
		<td style="text-align:left;"><?php echo $product['Product']['name']?> <small><b> - <?php __('Concept')?></b></small></td>
	<?php else: ?>
		<td style="text-align:left;"><?php echo $product['Product']['name']?></td>
	<?php endif;?>
			<td width="250px">
			<div class="edit"><small><a href="<?php echo HOME?>/admin/editproduct/<?php echo $product['Product']['id']?>"><?php __('Bewerk')?></a></small></div>
			<div class="putback"><small><a href="<?php echo HOME?>/admin/undeleteproduct/<?php echo $product['Product']['id']?>"><?php __('Zet terug')?></a></small></div>
			<div class="delete" style="width:180px"><small><a href="<?php echo HOME?>/admin/permanentdelete/<?php echo $product['Product']['id']?>"><?php __('Permanent verwijderen')?></a></small></div>
			</td>
		</tr>
		<?php endforeach; ?>
	<?php else: ?>
	<tr class="altrow">
		<td colspan="3" style="text-align:center;padding:10px 0px 20px 0px">
			<?php __('Uw prullenbak is leeg');?>
		</td>
	</tr> 
	<?php endif;?>
	<?php if($amount > AMOUNT_ON_PAGE):?>
	<tr class="tablefooter">
		<td colspan="4" class="tablefooter">			
			<div class="paginator_normal">
				<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
			</div>
		</td>
	</tr>
	<?php endif; ?>
</table>