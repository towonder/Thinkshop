<div class="productform">
<?php if($movie == false):?>
<h2><img src="<?php echo HOME?>/img/icons/media.png"/> Media <a href="<?php echo HOME?>/admin/addmedia/" class="pill add button"><span class="icon plus"></span>Nieuwe foto</a></h2>
<?php else: ?>
<h2><img src="<?php echo HOME?>/img/icons/media.png"/> Media <a href="<?php echo HOME?>/admin/addmedia/video" class="pill add button"><span class="icon plus"></span>Nieuwe video</a></h2>
<?php endif;?>
</div>

<div class="tabs">

</div>
<table cellpadding="0" cellspacing="0" class="maintable">
	<tr>
		<?php if($movie == false):?>
		<td><a href="<?php echo HOME?>/admin/media"><div class="foto_active">Foto's</div></a></td>
		<td><a href="<?php echo HOME?>/admin/media/true"><div class="video">Video's</div></a></td>
		<?php else:?>
		<td><a href="<?php echo HOME?>/admin/media"><div class="foto">Foto's</div></a></td>
		<td><a href="<?php echo HOME?>/admin/media/true"><div class="video_active">Video's</div></a></td>
		<?php endif; ?>
		<td colspan="2" style="background-color:#fafafa">
		</td>
	</tr>
	<?php if($amount > AMOUNT_ON_PAGE):?>
	<tr class="tablefooter" style="height:10px">
		<td colspan="4" class="tablefooter" style="height:10px;r">	
			<div class="paginator_normal">
				<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
			</div>
		
		</td>
	</tr>
	<?php endif; ?>
	<tr class="tablehead">
		<td width="110px"></td>
		<td><p>Titel</p></td>
		<td><p>Datum</p></td>
		<td width="200px"><p>Acties</p></td>
	</tr>	
	<tr class="altrow">
		<td colspan="4">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php if($movie == false):?>
	<?php foreach($photos as $item):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?> style="height:90px" id="foto_<?php echo $item['Photo']['id']?>">
		<td><img src="<?php echo HOME .'/'. $item['Photo']['thumb']?>" width="70px" style="margin-left:10px"/></td>
		<?php if(strlen($item['Photo']['name']) > 23):?>
		<td><?php echo substr($item['Photo']['name'], 0, 23)?>...</td>
		<?php else: ?>
		<td><?php echo $item['Photo']['name']?></td>
		<?php endif; ?>
		<td style="text-align:left">
			<?php $date = strtotime($item['Photo']['created']);?>
			<small><?php echo date("d/m/y", $date)?></small>
		</td>
		<?php $pid = $item['Photo']['id']; ?>
		<td>
			<div class="edit"><small><a href="<?php echo HOME?>/admin/editmedia/<?php echo $pid?>/photo">Bewerk</a></small></div>
			<div class="delete"><small><a href="javascript:deleteSomething(<?php echo $pid?>,'photo','#foto_<?php echo $pid?>', 'deze foto')">Verwijder</a></small></div>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php else: ?>
	<?php foreach($videos as $item):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?> style="height:90px" id="vid_<?php echo $item['Video']['id']?>">
		<td>
			<img src="<?php echo $item['Video']['thumb']?>" width="70px" style="margin-left:10px"/>
		</td>
		<?php if(strlen($item['Video']['title']) > 23):?>
		<td><?php echo substr($item['Video']['title'], 0, 23)?>...
		<?php else: ?>
		<td><?php echo $item['Video']['title']?>
		<?php endif; ?>
		<br/><small><?php echo ucwords($item['Video']['type'])?> movie</small></td>
		
		<td style="text-align:left">
			<?php $date = strtotime($item['Video']['created']);?>
			<small><?php echo date("d/m/y", $date)?></small>
		</td>
		<?php $vid = $item['Video']['id'];?>
		<td>
			<div class="edit"><small><a href="<?php echo HOME?>/admin/editmedia/<?php echo $item['Video']['id']?>/video">Bewerk</a></small></div>
			<div class="delete"><small><a href="javascript:deleteSomething(<?php echo $vid?>,'video','#vid_<?php echo $vid?>', 'deze video')">Verwijder</a></small></div>
		</td>
	</tr>
	<?php endforeach; ?>
	
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