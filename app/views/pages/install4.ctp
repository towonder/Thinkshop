<h2>Woops!</h2>
<div id="installdiv">
<?php

	if($error == 'tmp'){
		echo '<p>Thinkshop kan niet naar de <b>tijdelijke directory</b> schrijven...<br/>';
		echo 'pas de rechten aan van de map /app/tmp (stel deze in op chmod(777))</p><br/><br/>';
		echo '<a href="/install">Dat heb ik gedaan, ga door met installeren &raquo;</a>';
	}else if($error == "cache"){
		echo '<p>Er is geen <b>cache engine ingesteld</b>...<br/>';
		echo 'controleer aub de instellingen in /app/config/core.php </p><br/><br/>';
		echo '<a href="/install">Dat heb ik gedaan, ga door met installeren &raquo;</a>';		
	}else if($error == "nodbconnection"){
		echo '<p>Thinkshop kan <b>geen contact leggen met de database</b>...<br/>';
		echo 'controleer of de database correct is aangemaakt en vul de juiste gegevens opnieuw in...</p><br/><br/>';
		echo '<a href="/install">Dat heb ik gedaan, ga door met installeren &raquo;</a>';
		//link naar install.php
	}else if($error == "dbfilewrite"){
		echo '<p>Thinkshop heeft geen toestemming <b>om de database-file aan te maken</b>...<br/>';
		echo 'pas de rechten van de map /app/config/ aan, of hernoem het bestand /app/config/database.php.txt naar<br/>';
		echo '/app/config/database.php en pas de instellingen handmatig aan. </p><br/><br/>';
		echo '<a href="/install2">Dat heb ik gedaan, ga door met installeren &raquo;</a>';
	}
?>
</div>