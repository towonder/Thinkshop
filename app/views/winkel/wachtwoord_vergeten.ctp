<script type="text/javascript">
  	function submitForm(){
		$('#passwordform').submit();
	}
</script>


<div id="login">
<form id="passwordform" action="<?php echo HOME?>/winkel/wachtwoordVergeten/" method="post">	
<table cellpadding="0" cellspacing="0" id="logintable"  style="width:50%;margin-left:10px">
	<tr>
		<td colspan="2" style="text-align:center"><i>Geef hieronder uw email op, dan wordt u een nieuw wachtwoord opgestuurd.</i></td>
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
		<td colspan="2" style="text-align:right;"><br/>
			<img src="<?php echo HOME?>/img/frontside/passwordbtn.jpg" id="loginbtn" onClick="submitForm();"/>
		</td>
	</tr>
</table>
</form>
			
			
			
