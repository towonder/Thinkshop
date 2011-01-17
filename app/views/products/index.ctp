<div class="products">
	<div class="producttop">
		<h1>Collectie</h1>
	</div>
	

	<?php foreach($products as $product):?>
	
		<a href="/think/products/view/<?php echo $product['Product']['id']?>">
		<div class="product">
	
			<img src="<?php echo $product['Product']['image']?>">
			<div class="product_name">
				<?php echo $product['Product']['name']?>
			</div>
	
	
		</div>
		</a>
	
	<?php endforeach;?>
</div>
