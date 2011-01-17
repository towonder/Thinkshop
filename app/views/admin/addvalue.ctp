<div class="productform">
<h2>Nieuwe keuze</h2>
</div>

<form id="OptionAddForm" method="post" action="<?php echo HOME?>/admin/addvalue/<?php echo $id?>">
<table>
	<input type="hidden" name="data[Metavalue][metaterm_id]" value="<?php echo $id?>">
	<tr>
		<td><input type="text" name="data[Metavalue][name]" class="semi_text" value="Keuze naam" id="valuename" onclick="doSmartEmpty('#valuename', 'Waarde naam');"></td>
	</tr>
	<tr>
		<td><input type="text" name="data[Metavalue][value]" class="semi_text" value="Keuze afkorting" id="valuevalue" onclick="doSmartEmpty('#valuevalue', 'Waarde');"></td>
	</tr>
	<tr>
		<td><input type="text" name="data[Metavalue][icon]" class="semi_text" value="Keuze icoon" id="valueicon" onclick="doSmartEmpty('#valueicon', 'Waarde icoon');"></td>
	</tr>
	
	<tr>
		<td style="text-align:right"><input type="submit" value="Maak aan" name="Maak aan" class="submitbutton"/></td>
	</tr>
</table>

</form>

