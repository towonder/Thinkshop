<form name="login" action="<?php echo HOME?>/admin/login" method="post">
<table>
	<tr>
		<td style="text-align:right" width="130px">Naam:</td>
		<td><input type="text" name="data[Admin][naam]" class="small_text"></td>
	</tr>
	<tr>
		<td style="text-align:right">Wachtwoord:</td>
		<td><input type="password" name="data[Admin][wachtwoord]" class="small_text"></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:right"><input type="submit" value="Login" name="Login" class="submitbutton" style="margin-right:20px"></td>
	</tr>
	<tr>
		<td colspan="2"><small><a href="/think/admin/passwordforgot">Wachtwoord vergeten?</a></small></td>
	</tr>
</table>
</form>