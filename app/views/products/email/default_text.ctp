<?php

$date = strtotime($order['Order']['created']);
$month = date("m", $date);
$year = date("y", $date);


$ordernumber = $year . $month . $order_leading;


?>

Beste <?php echo $user['User']['voornaam']?>,<br/><br/>

Hartelijk dank voor uw bestelling! U heeft bij <a href="http://www.voorugeknipt.nl">voorugeknipt.nl</a> het volgende besteld:<br/><br/>

Ordernummber: <?php echo $ordernumber?>
<br/><br/>
	<?php 
	
		$total = 0;
		$totalsend = 0;
	
	?>
	
	<?php foreach($products as $product):?>
	<?php echo $product['name']?> - <?php echo $number->currency($product['price'], 'EUR')?>

	<?php
		$total += $product['price'];
		$total += $product['sendcost'];
		$totalsend += $product['sendcost'];
	?>
	<br/><br/>Verzendkosten:	<?php echo $number->currency($totalsend,'EUR')?>
	<br/><br/>Totaal: <?php echo $number->currency($total, 'EUR')?>


Wij verzoeken u vriendelijk om het verschuldigde bedrag (<?php echo $number->currency($total, 'EUR')?>) over te maken op rekening nummer 1234.12.123 Ten name van Voor u Geknipt.nl<br/><br/>

Vergeet niet bij uw overschrijving het ordernummer te plaatsen: <?php echo $ordernumber ?>
<br/><br/>
Nogmaals bedankt voor uw aankoop en graag tot ziens!<br/><br/>
Groetjes,<br/>
Miriam en Brigitte,<br/>
Voorugeknipt.nl