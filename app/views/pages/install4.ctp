<h2>Woops!</h2>
<div id="installdiv">
<?php

	$error = $_GET['error'];

	if($error == 'tmp'){
			echo '<p>Thinkshop is unable to write to the <b>temporary directory</b>...<br/>';
			echo 'change the permissions to the /app/tmp folder (change them to chmod(777))</p><br/><br/>';
			echo '<a href="install">I\'ve done that, please let me install &raquo;</a>';
	}else if($error == "cache"){
			echo '<p>There\'s no <b>cache-engine</b> set..';
			echo 'please check the settings in /app/config/core.php </p><br/><br/>';
			echo '<a href="install">I\'ve done that, please let me install &raquo;</a>';		
	}else if($error == "nodbconnection"){
			echo '<p>Thinkshop can\'t <b>contact the database</b>...<br/>';
			echo 'check if the database is created corretly and if your database-settings are correct...</p><br/><br/>';
			echo '<a href="install">I\'ve done that, please let me install &raquo;</a>';
	}else if($error == "dbfilewrite"){
			echo '<p>Thinkshop doens\'t have permissions <b>to create the database file</b>...<br/>';
			echo 'change the permissions to the /app/config/ folder, or rename the file /app/config/database.php.txt to<br/>';
			echo '/app/config/database.php and add the database information manually. </p><br/><br/>';
			echo '<a href="install2">Dat heb ik gedaan, ga door met installeren &raquo;</a>';
	}
?>
</div>