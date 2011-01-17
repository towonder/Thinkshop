<div class="productform">
<form id="ProductAddForm" method="post" action="/think/admin/addproduct/">
<table>
	<tr>
		<td colspan="2"><h3>Nieuw product:</h3></td>
	</tr>
	<tr>
		<td style="text-align:right" width="150px">Naam:</td>
		<td><input type="text" name="data[Product][name]"></td>
	</tr>
	<tr>
		<td style="text-align:right" valign="top">Beschrijving:</td>
		<td><textarea name="data[Product][description]"></textarea></td>
	</tr>
	<tr>
		<td style="text-align:right">Prijs: €</td>
		<td><input type="text" name="data[Product][price]">
	</tr>
	<tr>
		<td style="text-align:right">Verzendkosten: €</td>
		<td><input type="text" name="data[Product][sendcost]"></td>
	</tr>
	<tr>
		<td style="text-align:right">Collectie:</td>
		<td><select name="data[Product][collection_id]">
			<?php foreach($collections as $collection):?>
				<option value="<?php echo $collection['Collection']['id']?>"><?php echo $collection['Collection']['name']?></option>
			<?php endforeach; ?>
			</selector>
		</td>
	</tr>
	
	<tr>
		<td style="text-align:right">Uitverkoop:</td>
		<td><input type="checkbox" name="data[Product][sale]" value="1"></td>
	</tr>
	<tr>
		<td style="text-align:right">Verborgen:</td>
		<td><input type="checkbox" name="data[Product][hidden]" value="1"></td>
	</tr>
	
	
	<tr>	
		<td colspan="2" style="text-align:right"><input type="submit" value="Submit" class="submit"/></td>
<table>

</form>

