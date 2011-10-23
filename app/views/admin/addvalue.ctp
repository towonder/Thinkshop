<div class="productform">
<h2><?php __('Nieuwe keuze')?></h2>
</div>

<form id="OptionAddForm" method="post" action="<?php echo HOME?>/admin/addvalue/<?php echo $id?>">
<table>
	<input type="hidden" name="data[Metavalue][metaterm_id]" value="<?php echo $id?>">
	<tr>
		<td><input type="text" name="data[Metavalue][name]" class="semi_text" value="<?php __('Keuze naam')?>" id="valuename" onclick="doSmartEmpty('#valuename', '<?php __('Keuze naam')?>');"></td>
	</tr>
	<tr>
		<td><input type="text" name="data[Metavalue][value]" class="semi_text" value="<?php __('Keuze afkorting')?>" id="valuevalue" onclick="doSmartEmpty('#valuevalue', '<?php __('Keuze afkorting')?>');"></td>
	</tr>
	<tr>
		<td><input type="text" name="data[Metavalue][icon]" class="semi_text" value="<?php __('Keuze icoon')?>" id="valueicon" onclick="doSmartEmpty('#valueicon', '<?php __('Keuze icoon')?>"></td>
	</tr>
	
	<tr>
		<td style="text-align:right"><input type="submit" value="<?php __('Maak aan')?>" name="<?php __('Maak aan')?>" class="submitbutton"/></td>
	</tr>
</table>

</form>

