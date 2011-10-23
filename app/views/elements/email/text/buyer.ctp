<?php 	

$totalboth = 0;
$totaal = 0;
$sendcost = 0;
$totalVAT = 0;

	foreach($products as $product):

		$prijs = $product['Product']['price'] + ($product['Product']['price'] * $product['Product']['vat']);
		$totaal += $prijs;
		$sendcost += $product['Product']['sendcost'];
		
		if(SENDCOST_PER_PRODUCT == 'true'):
			$totalboth += $prijs + $product['Product']['sendcost'];
		else:
			$totalboth += $prijs;
		endif;

	endforeach;
	
	if(SENDCOST_PER_PRODUCT == 'false'){
		$sendcost = 0;
		$sendcost = SENDCOST;
		$totalboth += SENDCOST;
	}
	
?>

Beste <?php echo $order['User']['firstname'] .' '. $order['User']['lastname']?>,

Hartelijk dank voor uw bestelling bij <?php echo WEBSITE_TITLE ?>

Uw ordernummber: <?php echo '#'. sprintf("%04d",$order['Order']['id']);?>
<?php foreach($products as $product):?>

--------------
<?php echo $product['Product']['name']?>
<?php if(!empty($product['Options'])):?>

<?php foreach($product['Options'] as $option):?>
<?php echo $option['term'] .': '. $option['value'];?>

<?php endforeach;?>
<?php endif;?>

<?php $prijs = $product['Product']['price'] + ($product['Product']['price'] * $product['Product']['vat']); ?>
€<?php echo str_replace('.',',', $number->currency($prijs, ''));?>
<?php endforeach; ?>

--------------

Lopend totaal: €<?php echo str_replace('.',',', $number->currency($totaal, ''));?>

Verzendkosten:	€<?php echo str_replace('.',',',$number->currency($sendcost,''));?>

Totaal: €<?php echo str_replace('.',',', $number->currency($totalboth, ''));?>


<?php if($order['Order']['paid'] == 0):?>
Wij verzoeken u eerst het volledige bedrag (€<?php echo str_replace('.',',', $number->currency($totalboth, ''));?>) over te maken op rekeningnummer <?php echo ACCOUNT_NUMBER ?> t.n.v <?php echo ACCOUNT_NAME?>. Pas dan kunnen wij u de product(en) toesturen. 

Vergeet niet bij uw overschrijving het ordernummer te plaatsen: <?php echo '#'. sprintf("%04d",$order['Order']['id']);?>
<?php else: ?>
Uw betaling is binnen gekomen. U ontvangt uw bestelling zo spoedig mogelijk.
<?php endif; ?>


Nogmaals hartelijk bedankt voor uw bestelling,
Vriendelijke groet,

<?php echo WEBSITE_TITLE?>
