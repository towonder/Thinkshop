<div id="breadcrumbs">
	<!-- Homelink clickable: -->
	<a href="<?php echo HOME?>" alt="Voorpagina"><div id="homelink"></div></a>				
	
	<!-- Add crumbs: -->
	<?php if($pagename != 'Home'):?>
		<?php echo $crumb->getHtml($pagename, $pagechild, $pageposition) ;?>
	<?php endif; ?>
		
	<!-- Account & Cart: -->
	<a href="<?php echo HOME?>/winkel/winkelwagen/">	
	<div id="cartbutton" onclick="showCart();">
		<p>
		<?php if($amountInCart == 1):?>
			1 Product
		<?php else:?>
			<?php echo $amountInCart .' Producten'; ?>
		<?php endif;?>
			
		<img src="<?php echo HOME?>/img/frontside/showcart.jpg" /></p>
	</div>
	</a>
		
	<a href="<?php echo HOME?>/winkel/account/">
		<div id="accountbutton">
			<p>Account</p>
		</div>
	</a>
		
</div>
<?php if($amountInCart != 0):?>
<div id="cart">
	<div id="cartheader"></div>
	<div id="cartmiddle">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td class="topcart">Product</td>
				<td  class="topcart" style="text-align:right">Aantal</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<?php ?>
			<?php foreach($cartitems as $item):?>
			<?php $thisamount = 0;?>
			<?php foreach($item as $product):
				$thisamount++;
			endforeach; ?>
			
			<tr>
				<td><?php echo $item[0]['name']?></td>
				<td style="text-align:right"><p class="cartnumber"><?php echo $thisamount?></p></td>
			</tr>
			<?php endforeach;?>
			<?php ?>
			<tr>
				<td class="bottomcart">Totaal:</td>
				<td class="bottomcart" style="text-align:right"><p class="cartnumber">
					<?php echo $number->currency($totalPrice, 'EUR');?>
				</p></td>
			</tr>
		</table>
	</div>
	<div id="cartfooter">
	</div>
</div>
<?php endif;?>
</div>
