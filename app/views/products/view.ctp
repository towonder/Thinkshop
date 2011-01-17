<div class="products">
	<div class="producttop">
		<img src="<?php echo $product['Product']['top']?>">
	</div>
		
	<div class="product">
		<img src="<?php echo $product['Product']['image']?>">
	</div>
	
	<div class="productinfo">
		<table><tr><td class="text">
		<?php echo $product['Product']['description']?>
		<br/>
		<b>Bestel gratis en geheel vrijblijvend ons <a href="/knip/stalenpakket/">stoffen stalenpakket</a></b> 
			<div class="price">
				Prijs: <strong><?php echo '€'. $product['Product']['price']?></strong>
			</div>
		</td></tr>
		<tr><td style="text-align:right">
			<a href="/knip/products/editorder/<?php echo $product['Product']['id']?>">
				<img src="/knip/img/incart.png">
			</a>
		</td></tr>
		</table>
		
	</div>


	<div class="productfabrics">
		<div class="fabricsname">Verkrijgbaar in deze stoffen:</div><br/>

		<?php foreach($product['Fabrick'] as $fabric):?>
			<a href="/knip/products/showfabric/<?php echo $fabric['id']?>" class="lbOn">
				<div class="fabric"><img src="<?php echo $fabric['image']?>"></div>
			</a>
		
		<?php endforeach;?>
	</div>

	
	
	
</div>