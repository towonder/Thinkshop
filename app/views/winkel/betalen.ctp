<div id="payments">
<?php if($method == ''):?>
<h2 style="width:600px;text-align:center">Selecteer alstublieft een betaalmethode:</h2>
<div id="paydiv">
	<table style="text-align:center;" cellpadding="0" cellspacing="0">
		<tr>
			<?php if(PAY_IDEAL == true):?>
			<td>
				<a href="<?php echo HOME?>/winkel/betalen/ideal" />
					<img src="<?php echo HOME?>/img/frontside/icons/ideal.png" /><br/>
					<small>iDeal</small>
				</a>
			</td>
			<?php endif;?>
			<?php if(PAY_AFTER == true):?>
			<td>
				<a href="<?php echo HOME?>/winkel/betalen/afterwards">					
					<img src="<?php echo HOME?>/img/frontside/icons/cash.png" /><br/>
					<small>Overmaken</small>
				</a>
			</td>
			<?php endif;?>
		</tr>
	</table>
</div>
<?php else: ?>
<h2 style="width:600px;text-align:center">Betalen is in de demoversie niet mogelijk...</h2>
<?php endif;?>
</div>
