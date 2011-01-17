<div class="products">
	
	<div class="producttop">
		<img src="/knip/img/gegevenskop.png">
	</div>
	<?php
	
	$first = false;
	$data = $session->read('temp');

	if(!empty($data['User']['voornaam'])){
		$voornaam = $data['User']['voornaam'];
		$voornaamreq = false;
	}else{
		$voornaam = '';
		if(!empty($data)){
			$voornaamreq = true;
		}else{
			$voornaamreq = false;
		}
	}
	
	if(!empty($data['User']['achternaam'])){
		$achternaam = $data['User']['achternaam'];
		$achternaamreq = false;
	}else{
		$achternaam = '';
		if(!empty($data)){
			$achternaamreq = true;
		}else{
			$achternaamreq = false;
		}
	}
	
	if(!empty($data['User']['email'])){
		$email = $data['User']['email'];
		$emailreq = false;
	}else{
		$email = '';
		if(!empty($data)){
			$emailreq = true;
		}else{
			$emailreq = false;
		}
	}
	
	if(!empty($data['User']['adres'])){
		$adres = $data['User']['adres'];
		$adresreq = false;
	}else{
		$adres = '';
		if(!empty($data)){
			$adresreq = true;
		}else{
			$adresreq = false;
		}
	}
	
	if(!empty($data['User']['postcode'])){
		$postcode = $data['User']['postcode'];
		$postcodereq = false;
	}else{
		$postcode = '';
		if(!empty($data)){
			$postcodereq = true;
		}else{
			$postcodereq = false;
		}
	}
	
	if(!empty($data['User']['woonplaats'])){
		$woonplaats = $data['User']['woonplaats'];
	}else{
		$woonplaats = '';
	}
	
	?>
	
	
	<?php if($member == "false"):?>
	<form name="gegevens" action="/knip/products/douser/" method="post">
	
	<div class="user">
		<table>
			<tr>
				<td colspan="2"><a href="/knip/products/user/true">Ik heb al eens iets besteld bij voorugeknipt.nl</a></td>
			</tr>
			<input type="hidden" name="data[User][exists]" value="false">
			
			<tr>
				<td width="30%">Voornaam</td>
				<?php if($voornaamreq == true):?>
				<td><input type="text" name="data[User][voornaam]" class="required" value="<?php echo $voornaam; ?>"></td>
				<?php else:?>
				<td><input type="text" name="data[User][voornaam]" value="<?php echo $voornaam; ?>"></td>
				<?php endif; ?>
			</tr>
			<tr>
				<td>Achternaam</td>
				<?php if($achternaamreq == true):?>
				<td><input type="text" name="data[User][achternaam]" class="required" value="<?php echo $achternaam; ?>"></td>
				<?php else:?>
				<td><input type="text" name="data[User][achternaam]" value="<?php echo $achternaam; ?>"></td>
				<?php endif;?>
			</tr>
			<tr>
				<td>E-mail</td>
				<?php if($emailreq == true):?>
				<td><input type="text" name="data[User][email]" class="required" value="<?php echo $email; ?>"></td>
				<?php else:?>
				<td><input type="text" name="data[User][email]" value="<?php echo $email;?>"></td>
				<?php endif;?>
			</tr>
			<tr>
				<td>Adres & Huisnummer</td>
				<?php if($adresreq == true):?>
				<td><input type="text" name="data[User][adres]" class="required" value="<?php echo $adres; ?>"></td>
				<?php else: ?>
				<td><input type="text" name="data[User][adres]" value="<?php echo $adres; ?>"></td>
				<?php endif;?>
			</tr>
			<tr>
				<td>Postcode</td>
				<?php if($postcodereq == true): ?>
				<td><input type="text" name="data[User][postcode]" class="required" value="<?php echo $postcode; ?>"></td>
				<?php else: ?>
				<td><input type="text" name="data[User][postcode]" value="<?php echo $postcode; ?>"></td>
				<?php endif; ?>
			</tr>
			<tr>
				<td>Woonplaats</td>
				<td><input type="text" name="data[User][woonplaats]" value="<?php echo $woonplaats; ?>"></td>
			</tr>

			<tr>
				<td colspan="2"  class="hr">Voor toekomstige bestellingen kunt u hier een wachtwoord opgeven:</td>
			</tr>
			<tr>
				<td>Wachtwoord</td>
				<td><input type="password" name="data[User][wachtwoord1]"></td>
			</tr>
			<tr>
				<td>Wachtwoord (nogmaals)</td>
				<td><input type="password" name="data[User][wachtwoord2]"></td>
			</tr>
		</table>
			
						
	</div>
	<table width="450px" style="text-align:right">
		<tr><td><input type="submit" value="Betaalmethode selecteren >"></td></tr>
	</table>
	</form>
	
	<?php elseif($member == "true"):?>
	<form name="gegevens" action="/knip/products/douser/" method="post">
	
	<div class="user">
		<table>
			<tr>
				<td colspan="2"><a href="/knip/products/user/false">Ik heb nog niets besteld bij voorugeknipt.nl</a></td>
			</tr>
			<input type="hidden" name="data[User][exists]" value="true">
			<tr>
				<td width="30%">E-mail</td>
				<?php if($emailreq == true):?>
				<td><input type="text" name="data[User][email]" class="required" value="<?php echo $email?>"></td>
				<?php else:?>
				<td><input type="text" name="data[User][email]"></td>
				<?php endif; ?>
				
			</tr>
				<td>Wachtwoord</td>
				<td><input type="password" name="data[User][wachtwoord]"></td>
			</tr>
		
		</table>
			
	</div>
	
	<table width="450px" style="text-align:right">
		<tr><td><input type="submit" value="Betaalmethode selecteren >"></td></tr>
	</table>
	
	
	</form>
	<?php endif;?>
	
	
</div>