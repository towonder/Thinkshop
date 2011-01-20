<script type="text/javascript" src="<?php echo HOME?>/js/jquery-ui/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript">

	var count = 0;
	var photocount = 0;
	var videocount = 0;
	
	
	function showVariant(){
		if($('#variant').css('display','none')){
			$('#variant').css('display','inline');
		}			
	};
	
	function createNewCategory(){
		
		$("#loading").ajaxStart(function(){
			$(this).show();
			$('#searchbtn').hide();
		});
		$("#loading").ajaxStop(function(){
			$(this).hide();
			$('#searchbtn').show();
		});
		
		
		var name = $('#newcatname').val();
		$('#newcatname').val('Nieuwe categorie');
		
		$.ajax({
			url: "<?php echo HOME?>/admin/quickaddcategory/"+name,
			success: function(data){
				var newid = data;
				
				var div = '<div class="catspan">';
				div += "<div class='catselection' id='cate_"+newid+"'>";
				div += "<input type='checkbox' name='data[ProdCats][c_"+newid+"]' checked value='"+newid+"'/>";
				div += "<p style='display:inline;font-weight:bold'>"+name+"</p></div></div>";
				
				$('#oldcats').append(div);
				$('#cate_'+newid).effect("highlight", { times:2 }, 300);
				
			}
		});
	}
	
	function doDeleteMeta(id) {
		var name = "#meta_"+id;
		if ($(name).length == 0){
			$('#deletedMeta').append("<input type='hidden' name='data[DeletedMeta]["+count+"][id]' value='"+id+"' id='meta_"+id+"'/>");
			count++
		}else{
			$(name).remove();
		}
	}
	
	
	function deleteMedia(id, product, type){
		$.ajax({ 
			url: "<?php echo HOME?>/admin/removeMediaItem/"+id+"/"+product+"/"+type,
		  	success: function(data) {
				if(type == 'photo'){
		    		$('#p_'+id).fadeOut();
				}else{
					$('#v_'+id).fadeOut();	
				}
		  	}
		});
	}
	
	
		
</script>

<div class="productform">
<form id="EditForm" method="post" action="<?php echo HOME?>/admin/saveProduct/<?php echo $product['Product']['id']?>">
<input type="hidden" name="data[Product][id]" value="<?php echo $product['Product']['id']?>">
<?php if($product['Product']['name'] == 'Product naam'):?>
	<h2>Nieuw Product</h2>
<?php else: ?>
	<h2>Bewerk Product</h2>
<?php endif; ?>
<div  id="fluidtable">
<table>
	<tr>
		<td colspan="2"><input type="text" name="data[Product][name]" class="title_text" value="<?php echo $product['Product']['name']?>" id="productname" onclick="doSmartEmpty('#productname', 'Product naam');"></td>		
	</tr>
	<?php if(empty($product['Children']) && !empty($products)):?>
	<tr>
		<td colspan="2">
			<input type="checkbox" name="data[Product][parent]" <?php if($product['Product']['parent_id'] != '0'){ echo 'checked'; }?> onclick="showVariant();">
			<small>Dit product is een variant <div id="variant" <?php if($product['Product']['parent_id'] != '0'){ echo 'style="display:inline"';}else{ echo 'style="display:none"';}?>>van: 
				<select name="data[Product][parent_id]">
					<?php foreach($products as $prod):?>
						<option value="<?php echo $prod['Product']['id']?>" <?php if($product['Product']['parent_id'] == $prod['Product']['id']){ echo 'selected';}?>><?php echo $prod['Product']['name']?></option>
					<?php endforeach;?>
				</select>
			</div>
			</small>
		</td>
	</tr>
	<?php else:?>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<?php endif; ?>
	<?php if($product['Product']['parent_id'] == '0'):?>
	<tr>
		<td colspan="2">
			<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
				Beschrijving
			</div>
				<textarea name="data[Product][description]" class="mceEditor">
					<?php echo $product['Product']['description']?>
				</textarea>
		</td>
	</tr>
	<?php if(1 == 0):?>
	<tr>
		<td colspan="2">
			<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
				Samenvatting
			</div>
				<textarea name="data[Product][excerpt]" class="mceEditor">
					<?php echo $product['Product']['excerpt'];?>
				</textarea>
			
		</td>
	</tr>
	<?php endif; ?>
	<?php endif; ?>
	<tr>
		<td colspan="2">
			<div id="fotos">
				<div  class="description_text">Media <a href="<?php echo HOME?>/admin/medialibrary/<?php echo $product['Product']['id']?>" class="medialibrary pillsmall button" style="float:right;margin-top:-3px;margin-right:3px;padding-left:3px"><span class="plus icon"></span> media toevoegen</a></div>
				
				<?php if(!empty($product['Photo']) || !empty($product['Video'])):?>
					<div id="fotofiller">
						<?php foreach($product['Photo'] as $foto):?>
							<div class="photoitem" id="p_<?php echo $foto['id']?>" onclick="deleteMedia(<?php echo $foto['id']?>,<?php echo $product['Product']['id']?>,'photo')">
								<div class="deletethismedia"></div>	
								<img src="<?php echo HOME .'/'. $foto['thumb']?>" alt="<?php echo $foto['name']?>"><br/>
								<small>verwijder</small>
							</div>
						<?php endforeach;?>
						<?php foreach($product['Video'] as $video):?>
							<div class="photoitem videoitem" id="v_<?php echo $video['id']?>"  onclick="deleteMedia(<?php echo $video['id']?>,<?php echo $product['Product']['id']?>,'video')">
								<img src="<?php echo $video['thumb']?>" width="70px"><br/>
								<small>verwijder</small>
							</div>
						<?php endforeach;?>
					</div>
					<?php else: ?>
					<div id="fotofiller" style="text-align:center">	
						<p>Dit product heeft nog geen media-items</p>
					</div>
					<?php endif;?>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" id="cats">
			<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px;">
				Categorieën
			</div>
			<div id="productcategories">
				<div id="productcategoriesinner">
				<input type="text" name="data[Category][name]" class="field_text" style="width:65%;margin-left:5px" value="Nieuwe categorie" onClick="doSmartEmpty('#newcatname', 'Nieuwe categorie');" id="newcatname"/>
				<a class='pillsmall button' style="padding-left:3px;" href='#cats' id="searchbtn" onclick="createNewCategory()"><span class="plus icon"></span> Aanmaken</a>
				<div id="loading" style="display:none">
					<img src="<?php echo HOME?>/img/spinner.gif" width="30px">
				</div>
				<div id="oldcats">
				<?php foreach($categories as $category):?>
					<?php
					
						$inProd = false;
						foreach($product['Category'] as $cat){
							if($cat['id'] == $category['Category']['id']){
								$inProd = true;
							}
						}
					
					?>
				<div class="catspan">
					<div class="catselection">
						<?php if($inProd == false):?>
							<input type="checkbox" name="data[ProdCats][c_<?php echo $category['Category']['id']?>]" value="<?php echo $category['Category']['id']?>">
						<?php else: ?>
							<input type="checkbox" name="data[ProdCats][c_<?php echo $category['Category']['id']?>]" checked value="<?php echo $category['Category']['id']?>"/>
						<?php endif;?>
						<p style="display:inline;font-weight:bold"><?php echo $category['Category']['name']?></p>
					</div>
					<?php foreach($category['Kids'] as $kid):?>
						<?php

							$nProd = false;
							foreach($product['Category'] as $cat){
								if($cat['id'] == $kid['id']){
									$nProd = true;
								}
							}

						?>
						
					<!-- all subcategories too: -->
						<div class="catselection">
							<?php if($nProd == false):?>
								<input type="checkbox" name="data[ProdCats][c_<?php echo $kid['id']?>]" value="<?php echo $kid['id']?>">
							<?php else: ?>
								<input type="checkbox" name="data[ProdCats][c_<?php echo $kid['id']?>]" checked value="<?php echo $kid['id']?>"/>
							<?php endif;?>
							<p style="display:inline;"><?php echo $kid['name']?></p>	
						</div>
					
					<?php endforeach;?>
					</div>
				<?php endforeach;?>
				</div>
				</div>
			</div>
		</td>
	</tr>
	<?php if(ADVANCED == "true"):?>
	
	<!--- EXTRA FIELDS: -->
	<?php if(!empty($extrafields)):?>
	<tr>
	<td colspan="2"><div id="opties">Extra velden <small>(Laat het veld leeg als dit niet van toepassing is op <?php echo $product['Product']['name']?>)</small></div></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<?php $a = 0;?>
	<?php foreach($product['Extrafield'] as $field):?>
	<tr>
		<td style="text-align:right; padding-right:5px">
			<?php echo $field['name']?>:
		</td>
		<td>
			<?php if($field['value'] != null):?>
			<!-- it's an existing field -->
			
			<input type="text" name="data[Extrafield][<?php echo $a?>][value]" value="<?php echo $field['value']?>"class="smaller_text"/>
			<input type="hidden" name="data[Extrafield][<?php echo $a?>][id]" value="<?php echo $field['id']?>" />
			<input type="hidden" name="data[Extrafield][<?php echo $a?>][blank]" value="false" />
			<input type="hidden" name="data[Extrafield][<?php echo $a?>][product_id]" value="<?php echo $product['Product']['id']?>" />
			<?php else: ?> 
			<!-- it's a new field -->
			<input type="text" name="data[Extrafield][<?php echo $a?>][value]" class="smaller_text"/>
			<input type="hidden" name="data[Extrafield][<?php echo $a?>][id]" value="<?php echo $field['id']?>" />
			<input type="hidden" name="data[Extrafield][<?php echo $a?>][blank]" value="true" />
			<input type="hidden" name="data[Extrafield][<?php echo $a?>][product_id]" value="<?php echo $product['Product']['id']?>" />
			<?php endif;?>
			
		</td>
		
	</tr>
	<?php $a++;?>
	<?php endforeach;?>
	<tr><td colspan="2">&nbsp;</td></tr>
	<?php endif; ?>
	
	<?php if($product['Product']['parent_id'] == '0' && !empty($metaterms)):?>
	<!--- Product options: -->
	<tr>
		<td colspan="2"><div id="opties">Keuzelijsten <small>(Selecteer welke keuzes bij dit product van toepassing zijn)</small></div></td>
	</tr>
	<?php $a = 0;?>
	<?php foreach($metaterms as $metaterm):?>
	<?php if(!empty($metaterm['Metavalue'])):?>
	<tr>
		<td colspan="2"><div id="metas"><div class="description_text"><?php echo $metaterm['Metaterm']['plural']?></div>
			<?php $i = 0;?>
			<div id="metaitems">
			<?php foreach($metaterm['Metavalue'] as $metavalue):?>
				<div class="metaitem">
					<?php echo $metavalue['name']?><br/>
					<?php $inProduct = false; ?>
					<?php foreach($product['Metavalue'] as $met):?>
						<?php 	if($metavalue['id'] == $met['id']):
									$inProduct = true;
									continue;
								endif;
						?>
					<?php endforeach?>
					
					<?php if($inProduct == true):?>
					<input type="checkbox" name="data[Metaterm][<?php echo $a?>][Metavalue][<?php echo $i?>][id]" checked value="<?php echo $metavalue['id']?>" id="check_<?php echo $metavalue['id']?>" onClick="doDeleteMeta(<?php echo $metavalue['id']?>)"/>
					<?php else:?>
					<input type="checkbox" name="data[Metaterm][<?php echo $a?>][Metavalue][<?php echo $i?>][id]" value="<?php echo $metavalue['id']?>"/>
					<?php endif;?>
					
				</div>
			<?php $i++;?>
			<?php endforeach;?>
			<input type="hidden" name="data[Metaterm][<?php echo $a?>][id]" value="<?php echo $metaterm['Metaterm']['id']?>">
			
			</div>
		</div>
		</td>
	</tr>
	<?php $a++; ?>
	<?php endif;?>
	<?php endforeach;?>
	
	<tr>
		<td><div id="deletedMeta">
			
		</div>
		</td>
	</tr>
	<?php endif; ?>
	<?php endif; ?>
</table>
</div>
<div id="editsidebar">

	<div id="publish">
		<div class="description_text">Publiceer</div>
		<table id="publishtable" style="width:240px; margin-left:10px;margin-top:0px">
			<tr>
				<td colspan="2" style="padding-top:15px;padding-bottom:15px"><small>Als u dit product publiceert verschijnt het meteen op de site. Bij opslaan als concept gebeurt dit niet.</small></td>
			</tr>
			<tr>
				<td colspan="2">
					<?php
						
						if($product['Product']['hidden'] == 0){
							$status = 'Gepubliceerd';
						}else{
							$status = 'Concept';
						}
					
					
					?>
					Huidige status: <b><?php echo $status?></b>
				</td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td>
					<a href="#" class="medium pill button" style="float:left" onClick="submitForm('Product', false)">Publiceer</a>
				</td>
				<td>
					<a href="#" class="pill button" style="float:left" onClick="submitForm('Product', true)">Opslaan als concept</a>
				</td>
			</tr>
		</table>
	</div>
	
	<div id="mainimage">
		<div class="description_text">
			Hoofdafbeelding
			<a href="<?php echo HOME?>/admin/editmainpicture/<?php echo $product['Product']['id']?>/product" class="pillsmall button medialibrary2">
				<span class="icon pen"></span>Wijzig
			</a>
		</div>
		<?php if(!empty($product['Image']['large'])):?>			
			<?php
				
				$wh = getimagesize(HOME . $product['Image']['large']);
				$width = $wh[0];
				$height = $wh[1];				
				if($height > $width):
			?>
					<img src="<?php echo HOME . $product['Image']['large']?>" height="243px" id="mainimgbig">
				<?php else: ?>
					<img src="<?php echo HOME . $product['Image']['large']?>" width ="250px" id="mainimgbig" style="margin-top:10px">
				<?php endif; ?>
		<?php else: ?>
			<img src="<?php echo HOME?>/img/no_picture_large.png" height="243px" id="mainimgbig">
		<?php endif;?>
		<div id="editimage">
			<a href="<?php echo HOME?>/admin/editmainpicture/<?php echo $product['Product']['id']?>/product" class="pillsmall button medialibrary2" style="float:none;padding-left:16px;padding-right:16px">
				<span class="icon pen"></span>Wijzig
			</a>
			
		</div>
	</div>
	
	<?php if(empty($product['Children'])):?>
	<?php if(SENDCOST_PER_PRODUCT == 'true'):?>
	<div id="price">
	<?php else:?>
	<div id="price" style="height:150px">
	<?php endif;?>
		<div class="description_text">Prijs</div>
			<table style="width:250px;margin-top:10px">
				<tr>
					<td style="text-align:right">Prijs <small>(ex. BTW)</small>: €</td>
					<td><input type="text" class="nano_text" name="data[Product][price]" value="<?php echo str_replace('.', ',',$product['Product']['price'])?>"></td>
				</tr>
				<?php if(SENDCOST_PER_PRODUCT == 'true'):?>
				<tr>
					<td style="text-align:right" style="width:200px">Verzendkosten: €</td>
					<td><input type="text" class="nano_text" name="data[Product][sendcost]" value="<?php echo str_replace('.', ',', $product['Product']['sendcost'])?>"></td>
				</tr>
				<?php endif; ?>
				<tr>
					<td style="text-align:right">Korting:</td>
					<td><input type="text" class="nano_text" style="text-align:right" name="data[Product][discount]" value="<?php echo ($product['Product']['discount'] * 100)?>"> %</td>
				</tr>
				
				<tr>
					<td valign="top" style="text-align:right">Btw:</td>
					<td><input type="radio" class="price_radio" name="data[Product][vat]" value="0.19" <?php if($product['Product']['vat'] == '0.19'){ echo 'checked';}?>><small>19%</small><br/>
						<input type="radio" class="price_radio" name="data[Product][vat]" value="0.06" <?php if($product['Product']['vat'] == '0.06'){ echo 'checked';}?>><small>6%</small><br/>
						<input type="radio" class="price_radio" name="data[Product][vat]" value="0" <?php if($product['Product']['vat'] == '0'){ echo 'checked';}?>><small>0%</small>
					</td>
				</tr>
			</table>
	</div>
	<?php endif; ?>
	
	<?php if(ADVANCED == "true"):?>
	<?php if($product['Product']['parent_id'] == '0'):?>
	<div id="seo">
		<div class="description_text">Zoekmachine optimalisatie</div>
		<?php	
		
			if(empty($product['Product']['slug'])){
				$slug = strtolower(str_replace(' ', '-',$product['Product']['name']));
			}else{
				$slug = $product['Product']['slug'];
			}
			
			if(empty($product['Product']['pagetitle'])){
				$title = $product['Product']['name'];
			}else{
				$title = $product['Product']['pagetitle'];
			}
			
			?>
			<table width="200px" style="width:200px; margin-top:10px">
				<tr>
					<td>URL naam <small>(slug)</small></td>
				</tr>
				<tr>
					<td><input type="text" name="data[Product][slug]" value="<?php echo $slug?>" class="smaller_text"></td>
				</tr>
				<tr>
					<td>Pagina titel</td>
				</tr>
				<tr>
					<td><input type="text" name="data[Product][pagetitle]" value="<?php echo $title?>" class="smaller_text"></td>
				</tr>
				<tr>
					<td valign="top">Kernwoorden<br/><small>(gebruik comma's om te deze te scheiden)</small></td>
				</tr>
				<tr>
					<td valign="top"><input type="text" name="data[Product][pagemeta]" value="<?php echo $product['Product']['pagemeta']?>" class="smaller_text"></td>
				</tr>
			</table>
	</div>
	<?php endif; ?>
	<?php endif;?>

</div>
</form>

</div>	
	
