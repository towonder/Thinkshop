<script type="text/javascript">
  	function submitForm(){
		$('#loginform').submit();
	}
</script>


<div id="login">
<table cellpadding="0" cellspacing="0">
	<tr><td  style="width:50%">
	<form id="loginform" action="<?php echo HOME?>/winkel/login/<?php echo $redirectToAccount?>" method="post">	
	<table cellpadding="0" cellspacing="0" id="logintable"  style="width:50%">
		<tr>
			<td colspan="2" class="tabletext">Ik ben al klant bij <?php echo WEBSITE_TITLE?>:</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<!-- GIVE ERROR WHEN NEEDED: -->
		<?php if($error != null):?>
		<div id="errorborder">
		<tr>
			<td class="error" colspan="2"><b>Oops!</b><br/>
			<?php echo $error?></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		</div>
		<?php endif;?>
		<tr>
			<td><p class="extrawidth">E-mailadres:</p></td>
			<td><input type="text" name="data[User][email]" class="small_text"></td>
		</tr>
		<tr>
			<td><p class="extrawidth">Wachtwoord:</p></td>
			<td><input type="password" name="data[User][wachtwoord]" class="small_text"></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:right"><a href="<?php echo HOME?>/winkel/wachtwoordVergeten"><small>ik ben mijn wachtwoord vergeten...</small></a></td>
		</tr>	
		<tr>
			<td colspan="2" style="text-align:right;"><br/>
				<img src="<?php echo HOME?>/img/frontside/login.jpg" id="loginbtn" onclick="submitForm();"/>
			</td>
		</tr>
	</table>
</td>
<td valign="top" style="width:50%">
	<table cellpadding="0" cellspacing="0" id="redirecttable"  style="width:100%">
		<tr>
				<td colspan="2" class="tabletext">Ik ben hier voor de eerste keer:</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<p>Wij vragen u vriendelijk wat gegevens in te vullen om het bestellen veiliger en makkelijker te maken.</p>
			</td>
		</tr>
		<tr>
			<td colspan="2"><br/><br/>
				<a href="<?php echo HOME?>/winkel/nieuwAccount/">Maak een nieuw account aan &raquo;</a>
			</td>
		</tr>
	</table>
	


</td>
</tr>
</table>
</form>
			
			
			
			