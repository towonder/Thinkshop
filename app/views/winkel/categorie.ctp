<div id="category">
	
<?php foreach($products as $product):?>
	<div class="productsquare">
		<a href="<?php echo HOME .'/winkel/product/'. $product['Product']['id'] .'/'. $product['Product']['slug']?>">
			<img src="<?php echo HOME . $product['Image']['large']?>" width="175px" />
			<div class="productname">
				<table cellpadding="0" cellspacing="0" style="width:175px">
					<tr>
						<td style="width:50%"><?php echo $product['Product']['name']?></td>
						<td style="text-align:right;padding-right:10px">&raquo;</td>
					</tr>
				</table>
			</div>
		</a>
	</div>	
<?php endforeach; ?>

	<?php if($amountProducts > AMOUNT_ON_PAGE):?>
	<div class="paginator">
		<?php echo str_replace('|', ' ', $paginator->numbers(array('class' => 'numbers')));?>
	</div>
	<?php endif; ?>

</div>