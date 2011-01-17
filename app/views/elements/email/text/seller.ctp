Er is een order geplaatst via <?php echo WEBSITE_TITLE?>

Ordernummber: <?php echo '#'. sprintf("%04d",$order['Order']['id']);?>

	<?php 
	
		$total = 0;
		$totalsend = 0;
		$totalvat = 0;
		$totallopend = 0;
	?>
	
--------------	
<?php foreach($products as $product):?>
Product: <?php echo $product['Product']['name']?>

Prijs (ex btw): €<?php echo str_replace('.',',', $number->currency($product['Product']['price'], ''));?>

<?php if(!empty($product['Options'])):?>
<?php foreach($product['Options'] as $option):?>
<?php echo $option['term'] .': '. $option['value'];?>

<?php endforeach; ?>
<?php endif;?>
--------------
	<?php
		$totallopend += $product['Product']['price'];
		$total += $product['Product']['price'] + ($product['Product']['price'] * $product['Product']['vat']);
		if(SENDCOST_PER_PRODUCT == true){
			$total += $product['Product']['sendcost'];
			$totalsend += $product['Product']['sendcost'];
		}
		$totalvat += $product['Product']['price'] * $product['Product']['vat'];
	?>
<?php endforeach; ?>
<?php if(SENDCOST_PER_PRODUCT == false):	

	$totalsend = SENDCOST;
	$total += SENDCOST;

endif;?>

Lopend totaal: 	€<?php echo str_replace('.',',', $number->currency($totallopend, ''));?>

BTW:			€<?php echo str_replace('.',',', $number->currency($totalvat, ''));?>

Verzendkosten:	€<?php echo str_replace('.',',', $number->currency($totalsend, ''));?>

--------------

Totaal: 			€<?php echo str_replace('.',',', $number->currency($total, ''));?>


---------------------------------------------------------------

Klantgegevens:

Naam: <?php echo $order['User']['firstname'] .' '. $order['User']['lastname']?>

E-mail: <?php echo $order['User']['email']?>


<?php if(!empty($order['User']['invoiceaddress']) && !empty($order['User']['invoicezipcode']) && !empty($order['User']['invoicecity']) && !empty($order['User']['invoicecountry'])):?>

Bezorgadres:

<?php echo $order['User']['address']?>

<?php echo $order['User']['zipcode']?>

<?php echo $order['User']['city']?>

<?php echo $order['User']['country']?>


Factuuradres:

<?php echo $order['User']['invoiceaddress']?>

<?php echo $order['User']['invoicezipcode']?>

<?php echo $order['User']['invoicecity']?>

<?php echo $order['User']['invoicecountry']?>

<?php else:?>
Bezorg- & factuuradres:

<?php echo $order['User']['address']?>

<?php echo $order['User']['zipcode']?>

<?php echo $order['User']['city']?>

<?php echo $order['User']['country']?>

<?php endif;?>

<?php if($order['Order']['paid'] == '0'):?>
De klant is verzocht om het volledige bedrag (€<?php echo str_replace('.',',', $number->currency($total, ''))?>) over te maken.
<?php else: ?>
De klant heeft het bedrag (€<?php echo str_replace('.', ',', $number->currency($total, ''));?>) betaald met IDEAL.
<?php endif; ?>
Het ordernummer is: <?php echo '#'. sprintf("%04d",$order['Order']['id']);?>

Groeten,
Het <?php echo WEBSITE_TITLE?>-systeem.