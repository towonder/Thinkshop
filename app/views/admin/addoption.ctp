<div class="productform">
<h2>Nieuwe keuzelijst</h2>
</div>

<form id="OptionAddForm" method="post" action="<?php echo HOME?>/admin/addoption/">
<table>
	<tr>
		<td><input type="text" name="data[Metaterm][name]" class="semi_text" value="Naam" id="optionname" onclick="doSmartEmpty('#optionname', 'Naam');"></td>
	</tr>
	<tr>
		<td><input type="text" name="data[Metaterm][plural]" class="semi_text" value="Naam in meervoud" id="optionplural" onclick="doSmartEmpty('#optionplural', 'Naam in meervoud');"></td>
	</tr>
	<tr>
		<td style="text-align:right"><input type="submit" value="Maak aan" name="Maak aan" class="submitbutton"/></td>
	</tr>
</table>

</form>

