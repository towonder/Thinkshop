<div class="productform">
<h2><img src="<?php echo HOME?>/img/icons/news.png"/> <?php __('Nieuws')?> <a href="<?php echo HOME?>/admin/addpost/" class="pill add button"><span class="icon plus"></span><?php __('Nieuw bericht')?></a></h2>
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
		<td><p><?php __('Datum')?></p></td>
		<td><p><?php __('Titel')?></p></td>
		<td width="200px"><p><?php __('Acties')?></p></td>
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
		<td style="text-align:left;padding-left:20px; width:100px">
			<?php $date = strtotime($post['Post']['created']);?>
			<small><?php echo date("d/m/y", $date)?></small>
		</td>
		<td style="text-align:left; width:300px">
			<?php
					if($post['Post']['hidden'] == '1'){
						$naam = $post['Post']['title'] .'<small> - <b>'.__('Concept', true).'</b></small>';
					}else{
						$naam = $post['Post']['title'];
					}
			
			?>
			<?php echo $naam; ?>
		</td>
		<td>
			<div class="edit"><small><a href="<?php echo HOME?>/admin/editpost/<?php echo $post['Post']['id']?>"><?php __('Bewerk')?></a></small></div>
			<div class="delete"><small><a href="<?php echo HOME?>/admin/deletepost/<?php echo $post['Post']['id']?>"><?php __('Verwijder')?></a></small></div>
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