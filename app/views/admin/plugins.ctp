<div class="productform">
<h2><img src="<?php echo HOME?>/img/icons/plugins.png"/>  Plugins</h2>
</div>

<div class="tabs">

</div>
<table cellpadding="0" cellspacing="0" class="maintable">

	<?php if($amount > AMOUNT_ON_PAGE):?>
	<tr class="tablefooter" style="height:10px">
		<td colspan="4" class="tablefooter" style="height:10px">	
			<div class="paginator_normal">
				<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
			</div>
		
		</td>
	</tr>
	<?php endif; ?>
	
	<tr class="tablehead">
		<td width="200px"><p>Naam</p></td>
		<td width="100px"><p>Actief</p></td>
		<td width="300px"><p>Acties</p></td>
	</tr>	
	<tr class="altrow">
		<td colspan="4">&nbsp;</td>
	</tr>
	
	<?php $i = 0;?>
	<?php if(!empty($plugins)):?>
	<?php foreach($plugins as $plugin):

	//		if($product['Product']['parent_id'] == 0 || $product['Product']['parent_id'] == '0'):

				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}

				//print_r($product);

		?>
	<tr<?php echo $class;?>>
		<td style="text-align:left;">
			<p style="padding-left:30px"><?php echo $plugin['Plugin']['name'];?></p>
		</td>
		<td>
			<?php if($plugin['Plugin']['active'] == 0):?>
				Inactief
			<?php else: ?>
				Actief.
			<?php endif; ?>
		</td>
		<td>
			<?php if($plugin['Plugin']['active'] == 0):?>
				<div class="activate">
					<a href="<?php echo HOME?>/admin/activateplugin/<?php echo $plugin['Plugin']['id']?>">
						<small>Activeer</small>
					</a>
				</div>
			<?php else: ?>
				<div class="deactivate">
					<a href="<?php echo HOME?>/admin/deactivateplugin/<?php echo $plugin['Plugin']['id']?>">
						<small>De-Activeer</small>
					</a>
				</div>
			<?php endif; ?>

			<div class="settings">
				<a href="<?php echo HOME .'/'. $plugin['Plugin']['settingspath']?>">
					<small>Instellingen</small>
				</a>
			</div>

			<div class="delete" style="margin-left:15px">
				<a href="<?php echo HOME?>/admin/deleteplugin/<?php echo $plugin['Plugin']['id']?>">
					<small>Verwijder</small>
				</a>
			</div>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php endif; ?>

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