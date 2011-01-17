<?php

	$admin = $_GET['admin'];
	$password = $_GET['pass'];

?>


<h2>Uw installatie is voltooid!</h2>
<div id="installdiv">
<p>U kunt inloggen met de volgende gegevens:</p>
	<table>
		<tr>
			<td><b>Gebruikersnaam:</b></td>
			<td><?php echo $admin?></td>
		</tr>
		<tr>
			<td><b>Wachtwoord:</b></td>
			<td><?php echo $password?></td>
		</tr>
		<tr>
			<td colspan="2"><br/><br/></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:right">
				<a href="admin">Ik wil beginnen met mijn winkel en inloggen! &raquo;</a>
			</td>
		</tr>
	</table>
</form>
</div>