<?php

	// Als de tmp map niet writebaar is of de cache instellingen zijn niet goed, rerouten:
	$settings = Cache::settings();
	Configure::write('Config.language', 'eng');
	
	
	if(!is_writable(TMP)){
		Header('Location: install4?error=tmp');
	}else if(empty($settings)){
		Header('Location: install4?error=cache');
	}


	// edit security salt:
	$error = false;
	$url = CONFIGS.'core.php';
	$code = createCode(40);
	$contents = "	Configure::write('Security.salt', '".$code."'); ?>";
	
	
	if(is_writable($url)){
		$lines = file($url); 
		$last = sizeof($lines) - 1 ; 
		
		if($last >= 228 && $last < 231){
			unset($lines[$last]); 

			$fp = fopen($url, 'w'); 
			fwrite($fp, implode('', $lines)); 
			fclose($fp); 

			$file = fopen($url, 'a+');
			fwrite($file, $contents);
			fclose($file);
		}
	}else{
		$error = true;
	}
	
	
	function createCode($len){
		$pass = '';
		$lchar = 0;
		$char = 0;
		
			for($i = 0; $i < $len; $i++) {
				while($char == $lchar) {
					$char = rand(48, 109);
					if($char > 57) $char += 7;
					if($char > 90) $char += 6;
				}
				$pass .= chr($char);
				$lchar = $char;
			}
		return $pass;
	}
	

?>
<?php
	if($error == true){
		echo '<p>'.__('Uw security.salt is niet schrijfbaar in het bestand "app/config/core.php", pas de security.salt zelf aan..', true).'</p>';
	}
?>
<script type="text/javascript">

	function doSubmit(){
		$('#dbinstall').submit();
	}

</script>

<h2><?php __('Stap')?> 1</h2>
<div id="installdiv">
<p><?php __('Geef aub uw database informatie op')?>:</p>
<form name="databaseinstall" action="install2" method="post" id="dbinstall">
	<table>
		<tr>
			<td width="270px"><?php __('Database naam')?>:</td>
			<td><input type="text" name="name" class="smaller_text"/></td>
		</tr>
		<tr>
			<td><?php __('Gebruikersnaam')?>:</td>
			<td><input type="text" name="user" class="smaller_text"/></td>
		</tr>
		<tr>
			<td><?php __('Wachtwoord')?>:</td>
			<td><input type="text" name="password" class="smaller_text"/></td>
		</tr>
		<tr>
			<td><?php __('Database host')?><br/>
				<small>(<?php __('9 van de 10 keer is dit \'localhost\'')?>)</small>
			</td>
			<td>
				<input type="text" name="host" value="localhost" class="smaller_text"/></td>
			</td>
		</tr>
		<tr>
			<td><?php __('Prefix')?></td>
			<td>
				<input type="text" name="theprefix" value="" class="smaller_text">
			</td>
		<tr>
			<td colspan="2"><br/></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:right">
				<a href="#" onClick="doSubmit()" class="giant pill button" id="dbinstall"><?php __('Opslaan')?></a>
			</td>
		</tr>
	</table>
</form>
</div>