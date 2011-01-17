<div class="productform">
<h2>Nieuwe pagina</h2>

<form id="ProductAddForm" method="post" action="<?php echo HOME?>/admin/addpage/">
<table>
	<tr>
		<td><input type="text" name="data[Staticpage][title]" class="title_text" value="Bericht titel" id="pagetitle" onclick="doSmartEmpty('#pagetitle', 'Bericht titel');"></td>
	</tr>
	<tr>
		<td>
			<div  class="description_text" style="margin-top:10px;border:1px solid #cccccc; border-bottom:0px">
				Bericht
			</div>
				<textarea name="data[Staticpage][body]"  class="mceEditor_big">
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
					<td>Zet in topmenu: </td>
					<td><input type="checkbox" name="data[Staticpage][topmenu]" checked></td>
				</tr>				
			</table>
		</div>	
		
	</div>

</form>
</div>

