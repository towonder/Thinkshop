<?php

$maanden = array();
$maanden[1] = "Januari";
$maanden[2] = "Februari";
$maanden[3] = "Maart";
$maanden[4] = "April";
$maanden[5] = "Mei";
$maanden[6] = "Juni";
$maanden[7] = "Juli";
$maanden[8] = "Augustus";
$maanden[9] = "September";
$maanden[10] = "Oktober";
$maanden[11] = "November";
$maanden[12] = "December";



?>

<form name="addcost" action="<?php echo HOME?>/admin/addcost" method="post">
	<h3>Kostenpost toevoegen</h3>
	<table>
		<tr>
			<td>Naam:</td>
			<td><input type="text" name="data[Cost][naam]"></td>
		</tr>
		<tr>
			<td>Prijs (inclusief btw):</td>
			<td><input type="text" name="data[Cost][prijs]"></td>
		</tr>
		<tr>
			<td>Bon datum:</td>
			<td><select name="data[Cost][dag]">
					<?php for($i = 1; $i < 31; $i++){?>
						<option value="<?php echo $i?>" <?php if($i == date('j')){ echo 'selected'; }?>>
							<?php echo $i;?>
						</option>
					<?php }; ?>
				</select>
				<select name="data[Cost][maand]">
					<?php for($i = 1; $i < 12; $i++){?>
						<option value="<?php echo $i?>" <?php if($i == date('n')){ echo 'selected'; }?>>
							<?php echo $maanden[$i]?>
						</option>
					<?php };?>
				</select>
				<?php $jaar = date('Y');?>
				<select name="data[Cost][jaar]">
					<option value="<?php echo $jaar?>" selected><?php echo $jaar?></option>
					<option value="<?php echo $jaar - 1?>"><?php echo $jaar -1?></option>
					<option value="<?php echo $jaar - 2?>"><?php echo $jaar -1?></option>
					<option value="<?php echo $jaar - 3?>"><?php echo $jaar -1?></option>
					<option value="<?php echo $jaar - 4?>"><?php echo $jaar -1?></option>
					<option value="<?php echo $jaar - 5?>"><?php echo $jaar -1?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td>BTW:</td>
			<td><select name="data[Cost][btw]">
					<option value="hoog" selected>Hoog</option>
					<option value="laag">Laag</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="submit" name="Voeg toe" value="Voeg toe">
			</td>
		</tr>
	
</form>