<div class="productform">
<h2><img src="<?php echo HOME?>/img/icons/pages.png"/> Pagina's <a href="<?php echo HOME?>/admin/addpage/" class="pill add button"><span class="icon plus"></span>Nieuwe pagina</a></h2>
</div>




<table cellpadding="0" cellspacing="0" class="maintable">
	<?php if($amountPages > AMOUNT_ON_PAGE):?>
	<tr class="tablefooter" style="height:10px">
		<td colspan="5" class="tablefooter" style="height:10px">			
			<div class="paginator_normal">
				<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
			</div>
		</td>
	</tr>
	<?php endif; ?>
	
	<tr class="tablehead">
		<td><p>Datum</p></td>
		<td><p>Titel</p></td>
		<td width="200px"><p>Acties</p></td>
	</tr>
	
	<tr class="altrow">
		<td colspan="3">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php foreach($pages as $page):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?> style="height:50px">
		<td style="text-align:left;padding-left:20px; width:100px">
			<?php $date = strtotime($page['Staticpage']['created']);?>
			<small><?php echo date("d/m/y", $date)?></small>
		</td>
		<td style="text-align:left; width:300px"><?php echo $page['Staticpage']['title']?></td>
		<td>
			<div class="edit"><small><a href="<?php echo HOME?>/admin/editpage/<?php echo $page['Staticpage']['id']?>">Bewerk</a></small></div>
			<div class="delete"><small><a href="<?php echo HOME?>/admin/deletepage/<?php echo $page['Staticpage']['id']?>">Verwijder</a></small></div>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php if($amountPages > AMOUNT_ON_PAGE):?>
	<tr class="tablefooter" style="height:10px">
		<td colspan="5" class="tablefooter" style="height:10px">			
			<div class="paginator_normal">
				<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
			</div>
		</td>
	</tr>
	<?php endif; ?>
	
</table>