<script type="text/javascript" src="<?php echo HOME?>/js/quickflip/quickflip.js"></script>


<div class="productform">
<h2><?php __('Keuzelijsten')?>	<a href="<?php echo HOME?>/admin/addoption/" class="pill add button"><span class="icon plus"></span><?php __('Nieuwe Keuzelijst')?></a></h2>
</div>


<?php if(empty($metaterms)):?>
<table id="nooptions">
	<tr>
		<td><b><?php __('Keuzelijsten zijn opties die een klant bij producten kan selecteren (bijvoorbeeld de maat of de kleur van een kledingstuk)')?></b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><a href="<?php echo HOME?>/admin/addoption"><?php __('Klik hier om een keuzelijst te maken')?> &raquo;</a></td>
	</tr>
</table>

<?php else:?>
<?php foreach($metaterms as $term):

	$height = count($term['Metavalue']) * 67 + 140 ;
?>


<div class="quickFlip" style="height:<?php echo $height?>px">

<div class="quickFlipPanel" style="height:<?php echo $height?>">
<table cellpadding="0" cellspacing="0" class="maintable">
	<tr class="tablehead">
		<td colspan="2"><h3><?php echo $term['Metaterm']['plural']?></h3></td>
		<td style="text-align:right"><a href="#"><p class="quickFlipCta" style='margin-right:20px'><small><?php __('Bewerk keuzelijst')?></small></p></a></td>
	</tr>
	<tr>
		<th><?php __('Naam')?></th>
		<th><?php __('Afkorting')?></th>
		<th><?php __('Acties')?></th>
	</tr>
	<tr class="altrow">
		<td colspan="3">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php foreach($term['Metavalue'] as $value):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><p style="margin-left:20px"><?php echo $value['name']?></p></td>
		<td><p style="margin-left:5px"><?php echo $value['value']?></p></td>
		<td width="200px">
			<div class="edit"><small><a href="<?php echo HOME?>/admin/editvalue/<?php echo $value['id']?>"><?php __('Bewerk')?></a></small></div>
			<div class="delete"><small><a href="<?php echo HOME?>/admin/deletevalue/<?php echo $value['id']?>"><?php __('Verwijder')?></a></small></div>
		</td>
	</tr>
	<?php endforeach; ?>
	<tr class="altrow">
		<td colspan="3"><p style="margin-left:20px"><a href="<?php echo HOME?>/admin/addvalue/<?php echo $term['Metaterm']['id']?>" style="text-decoration:none"><img src="<?php echo HOME?>/img/icons/new.png">&nbsp;&nbsp;<?php __('Nieuwe keuze toevoegen')?></a></p></td>
	</tr>
	
</table>
</div>

<div class="quickFlipPanel" style="height:<?php echo $height?>">
<table cellpadding="0" cellspacing="0" class="edittable">
		<tr class="tablehead">
			<td colspan="2"><h3><i><?php __('Keuzelijst opties')?></i></h3></td>
			<td style="text-align:right"><a href="#"><p class="quickFlipCta" style='margin-right:20px'><small><?php __('Gereed')?></small></p></a></td>
		</tr>
		<tr><td colspan="2">
			<form name="editmetaterm" action="<?php echo HOME?>/admin/editoption/<?php echo $term['Metaterm']['id']?>" method="post">
			<input type="hidden" name="data[Metaterm][id]" value="<?php echo $term['Metaterm']['id']?>">
			<table cellpadding="0" cellspacing="0" class="editedittable" style="margin-left:20px;padding-bottom:20px;width:560px">
				<tr>
					<td style="text-align:right"><p style="margin-right:15px"><?php __('Naam')?>:</p></td>
					<td><input type="text" name="data[Metaterm][name]" value="<?php echo $term['Metaterm']['name']?>"></td>
					<td style="text-align:right"><p style="margin-right:15px"><?php __('Gebruik icoon')?>:</p></td>
					<td><input type="checkbox"></td>
				</tr>
				<tr>
					<td style="text-align:right"><p style="margin-right:15px"><?php __('Meervoud')?>:</p></td>
					<td><input type="text" name="data[Metaterm][plural]" value="<?php echo $term['Metaterm']['plural']?>"></td>
					<td style="text-align:right"><p style="margin-right:15px"><?php __('Meerdere keuzes selecteerbaar')?> <br/><small>(<?php __('door de klant')?>)</small>:</p></td>
					<td><input type="checkbox" checked></td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:right">
						<input type="submit" name="Bewerk" value="Bewerk"class="submitbutton" />
					</td>
				</tr>
				</form>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right">
						<td>
							<div class="delete" style="margin-left:240px"><small><a href="<?php echo HOME?>/admin/deleteoption/<?php echo $term['Metaterm']['id']?>"><?php __('Verwijder')?></a></small></div>
						</td>					
					</td>
				</tr>
			</table>
		</td></tr>
</table>
</div>

</div>
<?php endforeach; ?>
<?php endif;?>