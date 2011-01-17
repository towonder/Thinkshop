<div id="userdiv">
	<table style="text-align:center">
		<tr>
			<td>
				Uw account is succesvol aangemaakt en automatisch ingelogd!
			</td>
		</tr>
		<?php if($cartFull == true):?>
		<tr>
			<td>
				<a href="<?php echo HOME?>/winkel/checkBestelling">Klik hier om verder te gaan met uw bestelling &raquo;</a>
			</td>
		</tr>
		<?php else:?>
		<tr>
			<td>
				<a href="<?php echo HOME?>/winkel/">Klik hier om verder te gaan met winkelen &raquo;</a>
			</td>
		</tr>
		<?php endif;?>
	</table>
</div>