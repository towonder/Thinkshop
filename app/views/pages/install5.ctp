<?php
	Configure::write('Config.language', 'eng');
	$admin = $_GET['admin'];
	$password = $_GET['pass'];

?>


<h2><?php __('Uw installatie is voltooid')?>!</h2>
<div id="installdiv">
<p><?php __('U kunt inloggen met de volgende gegevens')?>:</p>
	<table>
		<tr>
			<td><b><?php __('Gebruikersnaam')?>:</b></td>
			<td><?php echo $admin?></td>
		</tr>
		<tr>
			<td><b><?php __('Wachtwoord')?>:</b></td>
			<td><?php echo $password?></td>
		</tr>
		<tr>
			<td colspan="2"><br/><br/></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:right">
				<a href="admin"><?php __('Ik wil beginnen met mijn winkel en inloggen')?>! &raquo;</a>
			</td>
		</tr>
	</table>
</form>
</div>