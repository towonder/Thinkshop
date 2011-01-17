<div class="productform">
<h2>Bewerk categorie</h2>
</div>

<form id="OptionAddForm" method="post" action="<?php echo HOME?>/admin/editcategory/<?php echo $id?>">
<table>
	<input type="hidden" name="data[Category][id]" value="<?php echo $cat['Category']['id']?>">
	<tr>
		<td colspan="2"><input type="text" name="data[Category][name]" class="semi_text" value="<?php echo $cat['Category']['name']?>"></td>
	</tr>
	<tr>
		<td>Subcategorie van:</td>
		<td>
			<?php if($cat['Category']['parent_id'] != '0'):?>
			<select name="data[Category][parent_id]">
					<option value="0">Niet van toepassing</option>
				<?php foreach($categories as $category):?>
					<option value="<?php echo $category['Category']['id']?>" <?php if($cat['Category']['parent_id'] == $category['Category']['id']){ echo 'selected';}?>><?php echo $category['Category']['name']?></option>
				<?php endforeach;?>
			</select>
			<?php else:?>
				<select name="data[Category][parent_id]">
						<option value='0' selected>Niet van toepassing</option>
						<?php foreach($categories as $category):?>
							<option value="<?php echo $category['Category']['id']?>"><?php echo $category['Category']['name']?></option>
						<?php endforeach;?>
					</select>	
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td  colspan="2"style="text-align:right"><input type="submit" value="Bewerk" name="Bewerk" class="submitbutton"/></td>
	</tr>
</table>

</form>

