<script type="text/javascript">

	function checkLogin(){
		
		var email = $('#em').val();
		
		$.ajax({
			url: "<?php echo HOME?>/admin/checkadminemail/"+email,
			success: function(data){				
				if(data == 'email_okay'){
					$('#loginform').submit();
				}else{
					$('.logincontainer').effect("shake", { times:2 }, 100);
					$('#loginerror').empty();
					$('#loginerror').append('<p>'+data+'</p>');
					$('#loginerror').show('fast');		
				}
			}
		})
		
	}		
</script>

<form name="login" action="<?php echo HOME?>/admin/passwordforgot" method="post" id="loginform">
<div id="loginerror" style="display:none">
	
</div>	
<table>
	<tr>
		<td colspan="2" style="text-align:center">
			<small>Voer uw emailadres in, er wordt u een<br/>nieuw wachtwoord gestuurd..</small>
		</td>
	</tr>
	<tr>
		<td style="text-align:right">Uw email:</td>
		<td><input type="text" name="data[Admin][email]" class="small_text" id="em"></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:right"><input type="button" value="Vraag aan" name="Vraag aan" class="submitbutton" style="margin-right:20px" onclick="checkLogin()"></td>
	</tr>
</table>
</form>

</div>	
<div id="loginbottom">
</div>
