<div class="productform">
<h2>Nieuw extra veld</h2>
</div>

<form id="AddExtraField" method="post" action="<?php echo HOME?>/admin/addextrafield/">
<table>
	<tr>
		<td><input type="text" name="data[Extraterm][name]" class="semi_text" value="Veld naam" id="fieldname" onclick="doSmartEmpty('#fieldname', 'Veld naam');"></td>
	</tr>
	<tr>
		<td style="text-align:right"><input type="submit" value="Maak aan" name="Maak aan" class="submitbutton"/></td>
	</tr>
</table>

</form>

