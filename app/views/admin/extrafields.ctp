<h2>Extra velden <a href="<?php echo HOME?>/admin/addextrafield/" class="pill add button"><span class="icon plus"></span>Nieuw veld</a></h2>

<table cellpadding="0" cellspacing="0" class="maintable">
	<tr class="tablehead">
		<td><p>Veldnaam</p></td>
		<td><p>Acties</p></td>
	</tr>

	<tr class="altrow">
		<td colspan="3">&nbsp;</td>
	</tr>
	<?php if(!empty($extrafields)):?>
	<?php $i = 0;?>
	<?php foreach($extrafields as $field):
	
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
	<tr<?php echo $class;?>>
		<td style="text-align:left;"><p style="margin-left:15px"><?php echo $field['Extraterm']['name']?></p></td>
		<td width="200">
			<div class="edit"><small><a href="<?php echo HOME?>/admin/editextrafield/<?php echo $field['Extraterm']['id']?>">Bewerk</a></small></div>
			<div class="delete"><small><a href="<?php echo HOME?>/admin/deleteextrafield/<?php echo $field['Extraterm']['id']?>">Verwijder</a></small></div>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php else:?>
	<tr class="altrow">
		<td colspan="2" style="text-align:center;padding:10px"><b>Extra velden kunt u aanmaken als u meer data bij een product wilt instellen (bijvoorbeeld een ISBN- of artikelnummer)</b></td>
	</tr>
	<tr class="altrow">
		<td colspan="2" style="text-align:center;padding:10px">		
			<a href="<?php echo HOME?>/admin/addextrafield/">Maak een extra veld aan &raquo;</a>
		</td>
	</tr>
	<?php endif; ?>				
</table>
