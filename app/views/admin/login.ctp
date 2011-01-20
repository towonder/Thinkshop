<script type="text/javascript">

	$(document).keyup(function(e){
		if(e.keyCode == 13){
			checkLogin();
		}
	});

	function checkLogin(){
		
		var username = $('#un').val();
		var pw = $('#pw').val();
		
		$.ajax({
			url: "<?php echo HOME?>/admin/checkLogin/"+username+"/"+pw,
			success: function(data){				
				if(data == 'login_okay'){
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

<form name="login" action="<?php echo HOME?>/admin/login" method="post" id="loginform">
<div id="loginerror" style="display:none">
	
</div>	
<table>
	<tr>
		<td style="text-align:right" width="130px">Naam:</td>
		<td><input type="text" name="data[Admin][naam]" class="small_text" id="un"></td>
	</tr>
	<tr>
		<td style="text-align:right">Wachtwoord:</td>
		<td><input type="password" name="data[Admin][wachtwoord]" class="small_text" id="pw"></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:right;"><a href="#" class="pill giant button" style="margin-right:20px" onClick="checkLogin()"><span class="icon key" ></span>&nbsp;&nbsp;Inloggen</a></td>
	</tr>
</table>
</form>

</div>	
<div id="loginbottom">
	<small><a href="<?php echo HOME?>/admin/passwordforgot">Wachtwoord vergeten?</a></small>
</div>
