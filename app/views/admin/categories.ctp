<div class="productform">
<h2><?php __('Categorie&euml;n')?>	<a href="<?php echo HOME?>/admin/addcategory/" class="pill add button"><span class="icon plus"></span><?php __('Nieuwe categorie')?></a></h2>
</div>


<table cellpadding="0" cellspacing="0" class="maintable">
	<tr class="tablehead">
		<td><p><?php __('Naam')?></p></td>
		<td><p><?php __('Acties')?></p></td>
	</tr>

	<tr class="altrow">
		<td colspan="3">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php foreach($categories as $category):
	
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
	<tr<?php echo $class;?>>
		<td style="text-align:left;"><p style="margin-left:15px"><?php echo $category['Category']['name']?></p></td>
		<td width="200">
			<div class="edit"><small><a href="<?php echo HOME?>/admin/editcategory/<?php echo $category['Category']['id']?>"><?php __('Bewerk')?></a></small></div>
			<div class="delete"><small><a href="<?php echo HOME?>/admin/deletecategory/<?php echo $category['Category']['id']?>"><?php __('Verwijder')?></a></small></div>
		</td>
	</tr>
		<?php foreach($category['Kids'] as $child):?>
		<tr <?php echo $class;?>>
			<td style="text-align:left;"><p style="margin-left:35px;font-size:12px">- <?php echo $child['name']?></p></td>
			<td width="200">
				<div class="edit"><small><a href="<?php echo HOME?>/admin/editcategory/<?php echo $child['id']?>"><?php __('Bewerk')?></a></small></div>
				<div class="delete"><small><a href="<?php echo HOME?>/admin/deletecategory/<?php echo $child['id']?>"><?php __('Verwijder')?></a></small></div>
			</td>	
		</tr>
		<?php endforeach;?>
	<?php endforeach; ?>
</table>
