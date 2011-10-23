<div class="productform">
<form id="ProductEditForm" method="post" action="<?php echo HOME?>/admin/addproduct/">
<h2><?php __('Nieuw Product')?></h2>
<table>

	<tr>
		<td><input type="text" name="data[Product][name]" class="title_text" value="<?php __('Product naam')?>" id="productname" onclick="doSmartEmpty('#productname', '<?php __('Product naam')?>');"></td>
	</tr>
	<tr>
		<td>
			<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
				<?php __('Beschrijving')?>
			</div>
				<textarea name="data[Product][description]"  class="mceEditor">
				</textarea>
		</td>
	</tr>
	<tr>
		<td>
			<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
				<?php __('Samenvatting')?>
			</div>
				<textarea name="data[Product][exerpt]"  class="mceEditor">
				</textarea>
		</td>
	</tr>	
</table>

<div id="editsidebar">

	<div id="publish">
		<div class="description_text"><?php __('Publiceer')?></div>
		<table id="publishtable" style="width:240px; margin-left:10px">
			<tr>
				<td><?php __('In categorie:')?></td>
				<td style="text-align:right"><select name="data[Product][category_id]" style="margin-right:10px">
					<?php foreach($categories as $category):?>
						<option value="<?php echo $category['Category']['id']?>"><?php echo $category['Category']['name']?></option>
					<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:15px;padding-bottom:15px"><small><?php __('Als u dit product publiceert verschijnt het meteen op de site. Bij opslaan gebeurt dit niet.')?></small></td>
			</tr>
			<tr>
				<td>
					<input type="submit" name="Publiceer" value="<?php __('Publiceer')?>" class="submitbutton" style="margin-left:0px">
				</td>
				<td style="text-align:right">
					<input type="submit" name="Bewaar" value="<?php __('Bewaar')?>" style="margin-right:10px" class="submitbutton">		
				</td>
			</tr>
		</table>
	</div>
	
	<div id="price">
		<div class="description_text"><?php __('Prijs')?></div>
			<table width="200px" style="width:200px">
				<tr>
					<td style="text-align:right"><?php __('Prijs')?> <small>(<?php __('ex. BTW')?>)</small>: €</td>
					<td><input type="text" class="price_text" name="data[Product][price]"></td>
				</tr>
				<tr>
					<td style="text-align:right"><?php __('Verzendkosten:')?> €</td>
					<td><input type="text" class="price_text" name="data[Product][sendcost]"></td>
				</tr>
				<tr>
					<td valign="top" style="text-align:right"><?php __('Btw')?>:</td>
					<td><input type="radio" class="price_radio" name="data[Product][vat]" value="0.19" checked><small>19%</small><br/>
						<input type="radio" class="price_radio" name="data[Product][vat]" value="0.06"><small>6%</small><br/>
						<input type="radio" class="price_radio" name="data[Product][vat]" value="0"><small>0%</small>
	</div>


<div>
	
	
	
</form>
