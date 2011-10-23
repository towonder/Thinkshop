<div class="productform">
<h2><?php __('Gebruiker bewerken')?></h2>
</div>

<form id="EditForm" method="post" action="<?php echo HOME?>/admin/edituser/<?php echo $admin['Admin']['id']?>">
<table>
	<tr>
		<input type="hidden" name="data[Admin][id]" value="<?php echo $admin['Admin']['id']?>"/>
		<td><input type="text" name="data[Admin][naam]" class="semi_text" value="<?php echo $admin['Admin']['naam']?>"/></td>
	</tr>
	<tr>
		<td><input type="text" name="data[Admin][email]" class="semi_text" value="<?php echo $admin['Admin']['email']?>" /></td>
	</tr>
	<tr>
		<td><br/><?php __('Wachtwoord')?>:</td>
	</tr>
	<tr>
		<td><input type="password" name="data[Admin][wachtwoord]" class="semi_text"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="padding-left:460px">
			<a href="#" class="pill giant button" onclick="submitForm('User', 'none')"><?php __('Bewerk')?></a>
		</td>
	</tr>
</table>

</form>

