<div class="productform">
<h2><?php __('Nieuw extra veld')?></h2>
</div>

<form id="AddExtraField" method="post" action="<?php echo HOME?>/admin/addextrafield/">
<table>
	<tr>
		<td><input type="text" name="data[Extraterm][name]" class="semi_text" value="<?php __('Veld naam')?>" id="fieldname" onclick="doSmartEmpty('#fieldname', '<?php __('Veld naam')?>');"></td>
	</tr>
	<tr>
		<td style="text-align:right"><input type="submit" value="<?php __('Maak aan')?>" name="<?php __('Maak aan')?>" class="submitbutton"/></td>
	</tr>
</table>

</form>

