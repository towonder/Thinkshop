<div class="productform">
<h2>Nieuwe categorie</h2>
</div>

<form id="OptionAddForm" method="post" action="<?php echo HOME?>/admin/addcategory/">
<table>
	<tr>
		<td colspan="2"><input type="text" name="data[Category][name]" class="semi_text" value="Categorie naam" id="categoryname" onclick="doSmartEmpty('#categoryname', 'Categorie naam');"></td>
	</tr>
	<tr>
		<td>Subcategorie van:</td>
		<td><select name="data[Category][parent_id]">
				<option value='0' selected>Niet van toepassing</option>
				<?php foreach($categories as $category):?>
					<option value="<?php echo $category['Category']['id']?>"><?php echo $category['Category']['name']?></option>
				<?php endforeach;?>
			</select>
		</td>
	</tr>
	<tr>
		<td style="text-align:right"><input type="submit" value="Maak aan" name="Maak aan" class="submitbutton"/></td>
	</tr>
</table>

</form>

