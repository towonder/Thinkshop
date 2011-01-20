<div class="productform">
<h2>Bericht bewerken</h2>

<form id="EditForm" method="post" action="<?php echo HOME?>/admin/editpost/<?php echo $post['Post']['id']?>">
	<input type="hidden" name="data[Post][id]" value="<?php echo $post['Post']['id']?>">
<div  id="fluidtable">	
<table>
	<tr>
		<td><input type="text" name="data[Post][title]" class="title_text" value="<?php echo $post['Post']['title']?>"></td>
	</tr>
	<tr>
		<td>
			<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
				Bericht
			</div>
				<textarea name="data[Post][body]"  class="mceEditor_big">
					<?php echo $post['Post']['body']?>
				</textarea>
		</td>
	</tr>
</table>
</div>


	<div id="editsidebar" style="margin-top:55px">

		<div id="publish">
			<div class="description_text">Publiceer</div>
			<table id="publishtable" style="width:240px; margin-left:10px">
				<tr>
					<td colspan="2" style="padding-top:15px;padding-bottom:15px"><small>Als u dit bericht publiceert verschijnt het meteen op de site. Bij opslaan als concept gebeurt dit niet.</small></td>
				</tr>
				<tr>
					<td colspan="2">
						<?php

							if($post['Post']['hidden'] == 0){
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
						<a href="#" class="medium pill button" style="float:left" onClick="submitForm('Post', false)">Publiceer</a>
					</td>
					<td>
						<a href="#" class="pill button" style="float:left" onClick="submitForm('Post', true)">Opslaan als concept</a>
					</td>
				</tr>
			</table>
		</div>	
		
		<?php if(ADVANCED == 'true'):?>
		<div id="seo">
			<div class="description_text">Zoekmachine optimalisatie</div>
				<table width="200px" style="width:200px">
					<tr>
						<td>URL naam <small>(slug)</small></td>
					</tr>
					<tr>
						<td><input type="text" name="data[Post][slug]" value="<?php echo $post['Post']['slug']?>" class="smaller_text"></td>
					</tr>
					<tr>
						<td>Pagina titel</td>
					</tr>
					<tr>
						<td><input type="text" name="data[Post][pagetitle]" value="<?php echo $post['Post']['pagetitle']?>" class="smaller_text"></td>
					</tr>
					<tr>
						<td valign="top">Kernwoorden<br/><small>(gebruik comma's om te deze te scheiden)</small></td>
					</tr>
					<tr>
						<td valign="top"><input type="text" name="data[Post][keywords]" value="<?php echo $post['Post']['keywords']?>" class="smaller_text"></td>
					</tr>
				</table>
		</div>
		<?php endif; ?>
		
		
	</div>



</form>

</div>

