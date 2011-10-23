<div class="productform">
<h2><?php __('Nieuwe categorie')?></h2>
</div>

<form id="EditForm" method="post" action="<?php echo HOME?>/admin/addcategory/">
<table>
	<tr>
		<td colspan="2"><input type="text" name="data[Category][name]" class="semi_text" value="<?php __('Categorie naam')?>" id="categoryname" onclick="doSmartEmpty('#categoryname', '<?php __('Categorie naam')?>');"></td>
	</tr>
	<tr>
		<td><?php __('Subcategorie van')?>:</td>
		<td><select name="data[Category][parent_id]">
				<option value='0' selected><?php __('Niet van toepassing')?></option>
				<?php foreach($categories as $category):?>
					<option value="<?php echo $category['Category']['id']?>"><?php echo $category['Category']['name']?></option>
				<?php endforeach;?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:450px">
			<a href="#" class="pill giant button" onClick="submitForm('Category', 'none')"><?php __('Voeg toe')?></a>			
		</td>
	</tr>
</table>

</form>

