<div class="productform">
<h2><?php __('Bewerk extra veld')?></h2>
</div>

<form id="OptionAddForm" method="post" action="<?php echo HOME?>/admin/editextrafield/<?php echo $id?>">
<table>
	<input type="hidden" name="data[Extraterm][id]" value="<?php echo $field['Extraterm']['id']?>">
	<tr>
		<td><input type="text" name="data[Extraterm][name]" class="semi_text" value="<?php echo $field['Extraterm']['name']?>"></td>
	</tr>
	<tr>
		<td style="text-align:right"><input type="submit" value="<?php __('Bewerk')?>" name="<?php __('Bewerk')?>" class="submitbutton"/></td>
	</tr>
</table>

</form>

