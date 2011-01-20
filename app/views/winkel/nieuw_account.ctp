<script type="text/javascript">
//SMART EMPTY OF NEW INPUTFIELDS
function doSmartEmpty(id){
	if($('#'+id).val() == id){
		
		$('#'+id).val('');
		$('#'+id).focus();
	}
	
	if(id == 'Adres'){
		if($('#Adres').val() == 'Straat & huisnummer'){
			$('#Adres').val('');
			$('#Adres').focus();
		}
	}
}
</script>
<div id="newuser">
<form name="newuser" action="<?php echo HOME?>/winkel/nieuwAccount" method="post">
<table cellspacing="0" cellpadding="0">
	<?php if(!empty($error)):?>
	<tr>
		<td colspan="2" class="erroruser">
			<h3><?php echo $error['title']?></h3>
			<p><?php echo $error['body']?></p>
		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<td colspan="2" id="begin">U kunt zich in twee eenvoudige stappen hieronder aanmelden</td>
	</tr>
	<tr>
		<td colspan="2" id="step"><b>Stap 1:</b> vertel ons wat over uzelf</td>
	</tr>
	<tr>
		<td class="label">Uw naam:</td>
		<td><input type="text" name="data[User][firstname]" value="<?php echo $data['User']['firstname']?>" class="input_text" style="width:180px" id="Voornaam" onClick="doSmartEmpty('Voornaam')"/>
			<input type="text" name="data[User][lastname]" value="<?php echo $data['User']['lastname']?>" class="input_text" style="width:180px" id="Achternaam" onclick="doSmartEmpty('Achternaam')" />
		</td>
	</tr>
	<tr>
		<td class="label">Geslacht:</td>
		<td><select name="data[User][gender]">
				<option value="m">Man</option>
				<option value="f">Vrouw</option>
			</select>
	<tr>
		<td class="label">Uw email: </td>
		<?php if($data['User']['email'] != 'error'):?>
		<td><input type="text" name="data[User][email]" value="<?php echo $data['User']['email']?>" class="input_text"  id="Email" onclick="doSmartEmpty('Email')"/></td>
		<?php else: ?>
		<td><input type="text" name="data[User][email]" value=" " class="input_text_error"  id="Email" onclick="doSmartEmpty('Email')"/></td>
		<?php endif;?>
	</tr>
	<tr>
		<td  class="label" valign="top">Adres: </td>
		<td><input type="text" name="data[User][address]" value="<?php echo $data['User']['address']?>" class="input_text"  id="Adres" onclick="doSmartEmpty('Adres')"/><br/>
			<input type="text" name="data[User][zipcode]" value="<?php echo $data['User']['zipcode']?>" class="input_postal"  id="Postcode" onclick="doSmartEmpty('Postcode')" MAXLENGTH="6"/><input type="text" name="data[User][city]" value="<?php echo $data['User']['city']?>" class="input_city" id="Woonplaats" onclick="doSmartEmpty('Woonplaats')"/>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<select name="data[User][country]" class="selector">
				<option value="Nederland" class="selector">Nederland</option>
				<option value="België" class="selector">Belgie</option>
				<option value="Anders" class="selector">Anders</option>
			</select>	
		</td>
	</tr>
	<tr>
		<td colspan="2" style="border-bottom:1px solid #666">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" id="step"><b>Stap 2:</b> stel uw wachtwoord in: <small>(minimaal 6 en maximaal 10 karakters)</small></td>
	</tr>
	<?php if(!empty($data['User']['password1'])):?>
	<tr>
		<td  class="label" >Wachtwoord:</td>
		<td><input type="password" name="data[User][password1]" class="input_text_error"/></td>
	</tr>
	<tr>
		<td  class="label" >Wachtwoord:<br/><small>(nogmaals)</small></td>
		<td><input type="password" name="data[User][password2]" class="input_text_error"/></td>
	</tr>
	<?php else:?>
	<tr>
		<td  class="label" >Wachtwoord:</td>
		<td><input type="password" name="data[User][password1]" class="input_text"/></td>
	</tr>
	<tr>
		<td  class="label" >Wachtwoord:<br/><small>(nogmaals)</small></td>
		<td><input type="password" name="data[User][password2]" class="input_text"/></td>
	</tr>
	<?php endif; ?>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:right;padding-right:20px">
			<input type="submit" name="Aanmelden" value="Aanmelden">
		</td>
	</tr>
</table>
</form>
</div>