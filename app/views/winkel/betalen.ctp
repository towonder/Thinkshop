<div id="payments">
<?php if($method == ''):?>
<h2 style="width:600px;text-align:center">Selecteer alstublieft een betaalmethode:</h2>
<div id="paydiv">
	<table style="text-align:center;" cellpadding="0" cellspacing="0">
		<tr>
			<?php if($useIdeal == true):?>
			<td>
				<a href="<?php echo HOME?>/winkel/betalen/ideal" />
					<img src="<?php echo HOME?>/img/frontside/icons/ideal.png" /><br/>
					<small>iDeal</small>
				</a>
			</td>
			<?php endif;?>
			<?php if($useAfterwards == true):?>
			<td>
				<a href="<?php echo HOME?>/winkel/betalen/afterwards">					
					<img src="<?php echo HOME?>/img/frontside/icons/cash.png" /><br/>
					<small>Overmaken</small>
				</a>
			</td>
			<?php endif;?>
			<?php if($usePaypal == true):?>
			<td>
				<a href="<?php echo HOME?>/winkel/betalen/paypal">					
					<img src="<?php echo HOME?>/img/frontside/icons/paypal.png" /><br/>
					<small>Paypal</small>
				</a>
			</td>
			<?php endif;?>
			<?php if($useCreditcard == true):?>
			<td>
				<a href="<?php echo HOME?>/winkel/betalen/creditcard">					
					<img src="<?php echo HOME?>/img/frontside/icons/creditcard.png" /><br/>
					<small>Creditcard</small>
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
