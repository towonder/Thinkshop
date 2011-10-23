<div class="productform">
<h2><?php __('Nieuwe gebruiker')?></h2>
</div>

<form id="EditForm" method="post" action="<?php echo HOME?>/admin/adduser/">
<table>
	<tr>
		<td><input type="text" name="data[Admin][naam]" class="semi_text" value="<?php __('Gebruiker naam')?>" id="username" onclick="doSmartEmpty('#username', '<?php __('Gebruiker naam')?>');"></td>
	</tr>
	<tr>
		<td><input type="text" name="data[Admin][email]" class="semi_text" value="<?php __('Gebruiker email')?>" id="useremail" onclick="doSmartEmpty('#useremail', '<?php __('Gebruiker email')?>');"></td>
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

