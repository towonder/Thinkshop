<div class="productform">
<h2><?php __('Nieuwe keuzelijst')?></h2>
</div>

<form id="OptionAddForm" method="post" action="<?php echo HOME?>/admin/addoption/">
<table>
	<tr>
		<td><input type="text" name="data[Metaterm][name]" class="semi_text" value="<?php __('Naam')?>" id="optionname" onclick="doSmartEmpty('#optionname', '<?php __('Naam')?>');"></td>
	</tr>
	<tr>
		<td><input type="text" name="data[Metaterm][plural]" class="semi_text" value="<?php __('Naam in meervoud')?>" id="optionplural" onclick="doSmartEmpty('#optionplural', '<?php __('Naam in meervoud')?>');"></td>
	</tr>
	<tr>
		<td style="text-align:right"><input type="submit" value="<?php __('Maak aan')?>" name="<?php __('Maak aan')?>" class="submitbutton"/></td>
	</tr>
</table>

</form>

