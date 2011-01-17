<div class="productform">
<h2>Nieuwe gebruiker</h2>
</div>

<form id="AddUserForm" method="post" action="<?php echo HOME?>/admin/adduser/">
<table>
	<tr>
		<td><input type="text" name="data[Admin][naam]" class="semi_text" value="Gebruiker naam" id="username" onclick="doSmartEmpty('#username', 'Gebruiker naam');"></td>
	</tr>
	<tr>
		<td><input type="text" name="data[Admin][email]" class="semi_text" value="Gebruiker email" id="useremail" onclick="doSmartEmpty('#useremail', 'Gebruiker email');"></td>
	</tr>
	<tr>
		<td><br/>Wachtwoord:</td>
	</tr>
	<tr>
		<td><input type="password" name="data[Admin][wachtwoord]" class="semi_text"/></td>
	</tr>
	<tr>
		<td style="text-align:right"><input type="submit" value="Maak aan" name="Maak aan" class="submitbutton"/></td>
	</tr>
</table>

</form>

