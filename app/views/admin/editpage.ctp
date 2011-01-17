<div class="productform">
<h2>Bericht bewerken</h2>

<form id="ProductAddForm" method="post" action="<?php echo HOME?>/admin/editpage/<?php echo $page['Staticpage']['id']?>">
	<input type="hidden" name="data[Staticpage][id]" value="<?php echo $page['Staticpage']['id']?>">
<table>
	<tr>
		<td><input type="text" name="data[Staticpage][title]" class="title_text" value="<?php echo $page['Staticpage']['title']?>"></td>
	</tr>
	<tr>
		<td>
			<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
				Bericht
			</div>
				<textarea name="data[Staticpage][body]"  class="mceEditor_big">
					<?php echo $page['Staticpage']['body']?>
				</textarea>
		</td>
	</tr>
</table>


	<div id="editsidebar">

		<div id="publish">
			<div class="description_text">Publiceer</div>
			<table id="publishtable" style="width:240px; margin-left:10px">
				<tr>
					<td colspan="2" style="padding-top:15px;padding-bottom:15px"><small>Als u deze pagina publiceert verschijnt hij meteen op de site. Bij opslaan gebeurt dit niet.</small></td>
				</tr>
				<tr>
					<td>
						<input type="submit" name="data[Staticpage][publish]" value="Publiceer" class="submitbutton" style="margin-left:0px">
					</td>
					<td style="text-align:right">
						<input type="submit" name="data[Staticpage][save]" value="Bewaar" style="margin-right:10px" class="submitbutton">		
					</td>
				</tr>
				<tr>
					<?php if($page['Staticpage']['menu'] != ''):?>
					<td>Zet in topmenu: </td>
					<td><input type="checkbox" name="data[Staticpage][topmenu]" checked></td>
					<?php else: ?>
					<td>Zet in topmenu: </td>
					<td><input type="checkbox" name="data[Staticpage][topmenu]"></td>	
					<?php endif; ?>
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
						<td><input type="text" name="data[Staticpage][slug]" value="<?php echo $page['Staticpage']['slug']?>" class="smaller_text"></td>
					</tr>
					<tr>
						<td>Pagina titel</td>
					</tr>
					<tr>
						<td><input type="text" name="data[Staticpage][pagetitle]" value="<?php echo $page['Staticpage']['pagetitle']?>" class="smaller_text"></td>
					</tr>
					<tr>
						<td valign="top">Kernwoorden<br/><small>(gebruik comma's om te deze te scheiden)</small></td>
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

