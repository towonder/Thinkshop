<?php 

	if(!empty($page['Staticpage']['location'])){
		$lat = explode(',',$page['Staticpage']['location']);
	}else{
		$lat[0] = '0';
		$lat[1] = '0';
	}
		
	if($page['Staticpage']['zoom'] == ''){
		$zoomNr = 0;
	}else{
		$zoomNr = $page['Staticpage']['zoom'];
	}
	
	if($page['Staticpage']['form'] == '0'){
		$contactpage = 'false';
	}else{
		$contactpage = 'true';
	}

?>

<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>
<script type="text/javascript" src="<?php echo HOME?>/js/locationpicker/locationpicker.js"></script>


<script type="text/javascript">

	var contactform = <?php echo $contactpage; ?>

	$(document).ready(function(){	
	
		var lat = '<?php echo $lat[0];?>';
		var ling = '<?php echo $lat[1];?>';
		var zoomNr = <?php echo $zoomNr; ?>;
	
		$('#latlong').locationPicker(lat, ling, zoomNr);
	
		$('#normalinput').click(function(){
			$('#normal').hide();
			$('.contactpage').show();
			$('#contactinput').attr('checked', true);
			$('#normalinput').attr('checked', false);
			contactform = 'true';
		});
	
		$('#contactinput').click(function(){
			$('#normal').show();
			$('.contactpage').hide();
			$('#contactinput').attr('checked', false);
			$('#normalinput').attr('checked', false);		
			contactform = 'false';
		});
	});
	
	
	function submitContact(type){
		if(type == 'publish'){
			$('#ContactForm').append('<input type="text" name="data[Staticpage][publish]" value="publish"/>');
		}else{
			$('#ContactForm').append('<input type="text" name="data[Staticpage][save]" value="save"/>');
		}
		
		$('#ContactForm').submit();
	
	}
	
	function submitNormal(type){
		if(type == 'publish'){
			$('#NormalForm').append('<input type="text" name="data[Staticpage][publish]" value="publish"/>');
		}else{
			$('#NormalForm').append('<input type="text" name="data[Staticpage][save]" value="save"/>');
		}
		
		$('#NormalForm').submit();
	}
	
	
</script>

<div class="productform">
<?php if($page['Staticpage']['title'] == 'Nieuwe pagina'):?>
	<h2><?php __('Nieuwe pagina')?></h2>	
<?php else: ?>
	<h2><?php __('Pagina bewerken')?></h2>
<?php endif;?>


<?php if($page['Staticpage']['form'] == '0'):?>
	<div id="normal" style="display:block">
<?php else:?>
	<div id="normal" style="display:none">	
<?php endif;?>

<form id="NormalForm" method="post" action="<?php echo HOME?>/admin/editpage/<?php echo $page['Staticpage']['id']?>">
	<input type="hidden" name="data[Staticpage][id]" value="<?php echo $page['Staticpage']['id']?>">

<div  id="fluidtable">
<table>
	<tr>
		<td><input type="text" name="data[Staticpage][title]" class="title_text" value="<?php echo $page['Staticpage']['title']?>"></td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="checkbox" name="data[Staticpage][form]" id="normalinput"/>
			<small><?php __('Dit is een contactpagina')?></small>
		</td>
	</tr>
	<tr>
		<td>
			<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
				<?php __('Bericht')?>
			</div>
				<textarea name="data[Staticpage][body]"  class="mceEditor_big">
					<?php echo $page['Staticpage']['body']?>
				</textarea>
		</td>
	</tr>
</table>
</div>

	<div id="editsidebar">

		<div id="publish" style="height:200px">
			<div class="description_text"><?php __('Publiceer')?></div>
			<table id="publishtable" style="width:260px; margin-left:10px">
				<tr>
					<?php if($page['Staticpage']['menu'] != ''):?>
					<td style="padding-top:15px"><?php __('Zet in topmenu')?>: </td>
					<td><input type="checkbox" name="data[Staticpage][topmenu]" checked></td>
					<?php else: ?>
					<td  style="padding-top:15px"><?php __('Zet in topmenu')?>: </td>
					<td><input type="checkbox" name="data[Staticpage][topmenu]"></td>	
					<?php endif; ?>
				</tr>	
				<tr>
					<td colspan="2" style="padding-top:15px;padding-bottom:15px"><small><?php __('Als u deze pagina publiceert verschijnt hij meteen op de site. Bij opslaan als concept gebeurt dit niet')?>.</small></td>
				</tr>
				<tr>
					<td colspan="2">
						<?php

							if($page['Staticpage']['hidden'] == 0){
								$status = 'Gepubliceerd';
							}else{
								$status = 'Concept';
							}


						?>
						<?php __('Huidige status')?>: <b><?php echo $status?></b>
					</td>
				</tr>
				<tr>
					<td colspan="2"><br/></td>
				</tr>
				<tr>
					<td>
						<a href="#" class="medium pill button" style="float:left" onClick="submitNormal('publish')"><?php __('Publiceer')?></a>
					</td>
					<td>
						<a href="#" class="pill button" style="float:left" onClick="submitNormal('concept')"><?php __('Opslaan als concept')?></a>
					</td>
				</tr>
			</table>
		</div>	
		
		<?php if(ADVANCED == 'true'):?>
		<div id="seo">
			<div class="description_text"><?php __('Zoekmachine optimalisatie')?></div>
				<table width="200px" style="width:200px">
					<tr>
						<td><?php __('URL naam')?> <small>(slug)</small></td>
					</tr>
					<tr>
						<td><input type="text" name="data[Staticpage][slug]" value="<?php echo $page['Staticpage']['slug']?>" class="smaller_text"></td>
					</tr>
					<tr>
						<td><?php __('Pagina titel')?></td>
					</tr>
					<tr>
						<td><input type="text" name="data[Staticpage][pagetitle]" value="<?php echo $page['Staticpage']['pagetitle']?>" class="smaller_text"></td>
					</tr>
					<tr>
						<td valign="top"><?php __('Kernwoorden')?><br/><small><?php __('(gebruik comma\'s om te deze te scheiden)')?></small></td>
					</tr>
					<tr>
						<td valign="top"><input type="text" name="data[Staticpage][keywords]" value="<?php echo $page['Staticpage']['keywords']?>" class="smaller_text"></td>
					</tr>
				</table>
		</div>
		<?php endif; ?>
		
		
	</div>
</form>

	</div>

<?php if($page['Staticpage']['form'] == '1'):?>
	<div id="fluidtable" class="contactpage" style="display:block">
<?php else:?>
	<div id="fluidtable" class="contactpage" style="display:none">
<?php endif;?>
	<form id="ContactForm" method="post" action="<?php echo HOME?>/admin/editpage/<?php echo $page['Staticpage']['id']?>">
		<input type="hidden" name="data[Staticpage][id]" value="<?php echo $page['Staticpage']['id']?>">
	<table>
		<tr>
			<td><input type="text" name="data[Staticpage][title]" class="title_text" value="<?php echo $page['Staticpage']['title']?>"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="checkbox"  checked name="data[Staticpage][form]" id="contactinput"/>
				<small><?php __('Deze pagina is een contactpagina')?></small>
			</td>
		</tr>
		<tr>
			<td>
				<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
					<?php __('Kaart')?> <small><?php __('(wil je geen kaart? laat het zoekveld dan leeg)')?></small>
				</div>
				<div id="lokatie">	
					<input type="text" name="data[Staticpage][location]" id="latlong" class="field_text" style="width:65%;margin-left:5px" value="<?php echo $page['Staticpage']['location']?>"/>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
					<?php __('Adresgegevens')?>:
				</div>
				<div id="adresgegevens">
					<table cellspacing="0" cellpadding="0">
						<tr>
							<td class="label"><?php __('Straat')?>: </td>
							<td><input type="text" name="data[Staticpage][street]"  class="small_text"  value="<?php echo $page['Staticpage']['street']?>" style="width:295px"/></td>
						</tr>
						<tr>
							<td class="label"><?php __('Postcode & woonplaats')?> </td>
							<td><input type="text" name="data[Staticpage][zipcode]" class="nano_text" value="<?php echo $page['Staticpage']['zipcode']?>" style="padding:5px;">&nbsp;<input type="text" name="data[Staticpage][city]" class="small_text" value="<?php echo $page['Staticpage']['city']?>" style="width:197px">
						</tr>
						<tr>
							<td class="label"><?php __('Land')?></td>
							<td><input type="text" name="data[Staticpage][country]" class="small_text" value="<?php echo $page['Staticpage']['country']?>" style="width:295px"></td>
						</tr>
						
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
					<?php __('Bericht')?>:
				</div>
					<textarea name="data[Staticpage][body]"  class="mceEditor">
						<?php echo $page['Staticpage']['body']?>
					</textarea>
			</td>
		</tr>
		
		
		
	</table>
	</div>
	
	
	<?php if($page['Staticpage']['form'] == '1'):?>
		<div id="editsidebar" class="contactpage" style="display:block">
	<?php else:?>
		<div id="editsidebar" class="contactpage" style="display:none">
	<?php endif;?>

		<div id="publish" style="height:200px">
				<div class="description_text"><?php __('Publiceer')?></div>
				<table id="publishtable" style="width:260px; margin-left:10px">
					<tr>
						<?php if($page['Staticpage']['menu'] != ''):?>
						<td style="padding-top:15px"><?php __('Zet in topmenu')?>: </td>
						<td><input type="checkbox" name="data[Staticpage][topmenu]" checked></td>
						<?php else: ?>
						<td  style="padding-top:15px"><?php __('Zet in topmenu')?>: </td>
						<td><input type="checkbox" name="data[Staticpage][topmenu]"></td>	
						<?php endif; ?>
					</tr>	
					<tr>
						<td colspan="2" style="padding-top:15px;padding-bottom:15px"><small><?php __('Als u deze pagina publiceert verschijnt hij meteen op de site. Bij opslaan als concept gebeurt dit niet')?>.</small></td>
					</tr>
					<tr>
						<td colspan="2">
							<?php

								if($page['Staticpage']['hidden'] == 0){
									$status = 'Gepubliceerd';
								}else{
									$status = 'Concept';
								}


							?>
							<?php __('Huidige status')?>: <b><?php echo $status?></b>
						</td>
					</tr>
					<tr>
						<td colspan="2"><br/></td>
					</tr>
					<tr>
						<td>
							<a href="#" class="medium pill button" style="float:left" onClick="submitContact('publish')"><?php __('Publiceer')?></a>
						</td>
						<td>
							<a href="#" class="pill button" style="float:left" onClick="submitContact('concept')"><?php __('Opslaan als concept')?></a>
						</td>
					</tr>
				</table>
			</div>	

			<div id="contactform">
				<div class="description_text"><?php __('Contactformulier')?></div>
					<table width="200px" style="width:200px;margin-top:15px">
						<tr>
							<td><?php __('Stuur mails naar')?>:</td>
						</tr>
						<tr>
							<td><input type="text" name="data[Staticpage][mail_to]" value="<?php echo $page['Staticpage']['mail_to']?>" class="smaller_text"></td>
						</tr>
						<tr>
							<td><?php __('Gebruik anti-spam check')?>:</td>
						</tr>
						<tr>
							<?php if($page['Staticpage']['use_captcha'] == '1'):?>
								<td><input type="checkbox" name="data[Staticpage][use_captcha]" checked /></td>	
							<?php else: ?>
								<td><input type="checkbox" name="data[Staticpage][use_captcha]" /></td>
							<?php endif; ?>
						</tr>
					</table>
			</div>
			
			<?php if(ADVANCED == 'true'):?>
			<div id="seo">
				<div class="description_text"><?php __('Zoekmachine optimalisatie')?></div>
					<table width="200px" style="width:200px;margin-top:15px">
						<tr>
							<td><?php __('URL naam')?> <small>(slug)</small></td>
						</tr>
						<tr>
							<td><input type="text" name="data[Staticpage][slug]" value="<?php echo $page['Staticpage']['slug']?>" class="smaller_text"></td>
						</tr>
						<tr>
							<td><?php __('Pagina titel')?></td>
						</tr>
						<tr>
							<td><input type="text" name="data[Staticpage][pagetitle]" value="<?php echo $page['Staticpage']['pagetitle']?>" class="smaller_text"></td>
						</tr>
						<tr>
							<td valign="top"><?php __('Kernwoorden')?><br/><small>(<?php __('gebruik comma\'s om te deze te scheiden')?>)</small></td>
						</tr>
						<tr>
							<td valign="top"><input type="text" name="data[Staticpage][keywords]" value="<?php echo $page['Staticpage']['keywords']?>" class="smaller_text"></td>
						</tr>
					</table>
			</div>
			<?php endif; ?>
		</div>
	</form>
</div>
</div>

