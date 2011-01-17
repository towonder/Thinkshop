<div class="productform">
<h2><img src="<?php echo HOME?>/img/icons/news.png"/> Nieuws <a href="<?php echo HOME?>/admin/addpost/" class="addnewbutton">Nieuw bericht</a></h2>
</div>

<table cellpadding="0" cellspacing="0" class="maintable">
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
		<td><p>Datum</p></td>
		<td><p>Titel</p></td>
		<td><p>Acties</p></td>
	</tr>
	<tr class="altrow">
		<td colspan="3">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php foreach($posts as $post):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?> style="height:50px">
		<td style="text-align:center; width:140px">
			<?php $date = strtotime($post['Post']['created']);?>
			<small><?php echo date("d/m/y", $date)?></small>
		</td>
		<td style="text-align:center; width:300px"><?php echo $post['Post']['title']?></td>
		<td>
			<div class="edit"><small><a href="<?php echo HOME?>/admin/editpost/<?php echo $post['Post']['id']?>">Bewerk</a></small></div>
			<div class="delete"><small><a href="<?php echo HOME?>/admin/deletepost/<?php echo $post['Post']['id']?>">Verwijder</a></small></div>
		</td>
	</tr>
	<?php endforeach; ?>
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