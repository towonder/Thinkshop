<div class="productform">
<h2>Bewerk keuze</h2>
</div>

<form id="OptionAddForm" method="post" action="/think/admin/editvalue/<?php echo $id?>">
<table>
	<input type="hidden" name="data[Metavalue][metaterm_id]" value="<?php echo $term['Metavalue']['metaterm_id']?>">
	<input type="hidden" name="data[Metavalue][id]" value="<?php echo $term['Metavalue']['id']?>">
	<tr>
		<td class="tableright">Naam:</td>
		<td><input type="text" name="data[Metavalue][name]" class="semi_text" value="<?php echo $term['Metavalue']['name']?>"></td>
	</tr>
	<tr>
		<td class="tableright">Afkorting:</td>
		<td><input type="text" name="data[Metavalue][value]" class="semi_text" value="<?php echo $term['Metavalue']['value']?>"></td>
	</tr>
	<tr>
		<td class="tableright">Icoon:</td>
		<td><input type="text" name="data[Metavalue][icon]" class="semi_text" value="<?php echo $term['Metavalue']['icon']?>"></td>
	</tr>
	
	<tr>
		<td colspan="2"style="text-align:right"><input type="submit" value="Bewerk" name="Bewerk" class="submitbutton"/></td>
	</tr>
</table>

</form>

