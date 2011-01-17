<?php

$date = strtotime($order['Order']['created']);
$month = date("m", $date);
$year = date("y", $date);


$ordernumber = $year . $month . $order_leading;


?>

Beste <?php echo $user['User']['voornaam']?>,<br/><br/>

Hartelijk dank voor uw bestelling! U heeft bij <a href="http://www.voorugeknipt.nl">voorugeknipt.nl</a> het volgende besteld:<br/><br/>

<b>Ordernummber: <?php echo $ordernumber?></b>
<br/><br/>
<table border="0px">
	<tr>
		<td colspan="2">Product:</td>
		<td>Prijs:</td>
	</tr>
	<?php 
	
		$total = 0;
		$totalsend = 0;
	
	?>
	
	<?php foreach($products as $product):?>
	<tr>
		<td><img src="http://localhost:8888<?php echo $order['image']?>" width="50px"></td>
		<td><?php echo $product['name']?></td>
		<td><?php echo $number->currency($product['price'], 'EUR')?></td>
	</tr>
	<?php
		$total += $product['price'];
		$total += $product['sendcost'];
		$totalsend += $product['sendcost'];
	?>
	<tr>
		<td>Verzendkosten:</td>
		<td><?php echo $number->currency($totalsend,'EUR')?></td>
	</tr>
	<tr>
		<td>Totaal:</td>
		<td><?php echo $number->currency($total, 'EUR')?></td>
	</tr>
</table>

Wij verzoeken u vriendelijk om het verschuldigde bedrag (<?php echo $number->currency($total, 'EUR')?>) over te maken op rekening nummer 1234.12.123 Ten name van Voor u Geknipt.nl<br/><br/>

<b>Vergeet niet bij uw overschrijving het ordernummer te plaatsen: <?php echo $ordernumber ?></b>
<br/><br/>
Nogmaals bedankt voor uw aankoop en graag tot ziens!<br/><br/>
Groetjes,<br/>
Miriam en Brigitte,<br/>
Voorugeknipt.nl