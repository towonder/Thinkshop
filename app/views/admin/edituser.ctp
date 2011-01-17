<div class="productform">
<h2>Gebruiker bewerken</h2>
</div>

<form id="AddUserForm" method="post" action="<?php echo HOME?>/admin/edituser/<?php echo $admin['Admin']['id']?>">
<table>
	<tr>
		<input type="hidden" name="data[Admin][id]" value="<?php echo $admin['Admin']['id']?>"/>
		<td><input type="text" name="data[Admin][naam]" class="semi_text" value="<?php echo $admin['Admin']['naam']?>"/></td>
	</tr>
	<tr>
		<td><input type="text" name="data[Admin][email]" class="semi_text" value="<?php echo $admin['Admin']['email']?>" /></td>
	</tr>
	<tr>
		<td><br/>Wachtwoord:</td>
	</tr>
	<tr>
		<td><input type="password" name="data[Admin][wachtwoord]" class="semi_text"/></td>
	</tr>
	<tr>
		<td style="text-align:right"><input type="submit" value="Bewerk" name="Bewerk" class="submitbutton"/></td>
	</tr>
</table>

</form>

