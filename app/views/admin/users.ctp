<div class="productform">
<h2><img src="<?php echo HOME?>/img/icons/users.png"/> Gebruikers <a href="<?php echo HOME?>/admin/adduser/" class="addnewbutton">Nieuwe gebruiker</a></h2>
</div>

<table cellpadding="0" cellspacing="0" class="maintable_orders">
	<tr class="tablehead">
		<td><p>Naam</p></td>
		<td><p>Acties</p></td>
	</tr>
	<tr class="altrow">
		<td colspan="4">&nbsp;</td>
	</tr>
	<?php $i = 0;?>
	<?php foreach($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<?php if($user['Admin']['id'] != '3'):?>
	<tr<?php echo $class;?>>
		<td style="text-align:left">
			<p style="margin-left:15px"><?php echo ucwords($user['Admin']['naam'])?></p>
		</td>
		<td style="text-align:center">
			<div class="edit"><small><a href="<?php echo HOME?>/admin/edituser/<?php echo $user['Admin']['id']?>">Bewerk</a></small></div>
			<div class="delete"><small><a href="<?php echo HOME?>/admin/deleteuser/<?php echo $user['Admin']['id']?>">Verwijder</a></small></div>
		
		</td>
	</tr>
	<?php endif;?>
	<?php endforeach; ?>	
</table>