<script type="text/javascript">

	function toggleSendCost(){
		$('#sendcost').toggle();
	}

</script>

<h2><img src="<?php echo HOME?>/img/icons/settings.png"/> Instellingen</h2>
<div id="settingscollection">
<form name="settings" id="EditForm" action="<?php echo HOME?>/admin/settings" method="post">	
<table  class="settinggroup">
<tr>
	<td colspan="2" class="settingtitle">Kern instellingen</td>
</tr>	
<tr>
	<td class="alignright">
		<p>Website titel:</p>
	</td>
	<td>
		<input type="text" name="data[Setting][1]" value="<?php echo $settings[0]['Setting']['pair']?>" class="small_text">
	</td>
</tr>
<tr>
	<td class="alignright">
		<p>Website url:</p>
	</td>
	<td style="width:200px">
		<input type="text" name="data[Setting][2]" value="<?php echo $settings[1]['Setting']['pair']?>" class="small_text">
	</td>
</tr>
<tr>
	<td class="alignright">
		<p>Relatieve url:</p>
	</td>
	<td>
		<input type="text" name="data[Setting][3]" value="<?php echo $settings[2]['Setting']['pair']?>" class="small_text">
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>

<tr>
	<td colspan="2" style="border-top:1px dotted #cccccc"></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>


<?php if($settings[12]['Setting']['pair'] == 'true'):?>
<tr>
	<td class="alignright">Verzendkosten per product aangeven:</td>
	<td>
		<input type="checkbox" name="data[Setting][17]" checked onClick="toggleSendCost();"/>
	</td>
</tr>

<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr id="sendcost">
	<td class="alignright">Algemene verzendkosten:</td>
	<td>
		<input type="text" name="data[Setting][18]" value="<?php echo str_replace('.',',', $settings[13]['Setting']['pair'])?>" class="small_text"></td>
</tr>

<?php else:?>
<tr>
	<td class="alignright">Verzendkosten per product aangeven:</td>
	<td>
		<input type="checkbox" name="data[Setting][17]"  onClick="toggleSendCost();"/>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr id="sendcost" style="display:table-row">
	<td class="alignright">Algemene verzendkosten:</td>
	<td>
		<input type="text" name="data[Setting][18]" value="€ <?php echo str_replace('.',',', $settings[13]['Setting']['pair'])?>" class="small_text"></td>
</tr>

<?php endif;?>

</table>

<table  class="settinggroup">
<tr>
	<td colspan="2" class="settingtitle">Contact instellingen</td>
</tr>	
<tr>
	<td class="alignright">
		<p>Ontvangstadres: <small>(email)</small></p>
	</td>
	<td>
		<input type="text" name="data[Setting][15]" value="<?php echo $settings[10]['Setting']['pair']?>" class="small_text">
	</td>
</tr>
<tr>
	<td class="alignright">
		<p>Anti spam gebruiken:</p>
	</td>
	<td>
		<?php if($settings[11]['Setting']['pair'] == 'true'):?>
		<input type="checkbox" name="data[Setting][16]" checked />
		<?php else:?>
		<input type="checkbox" name="data[Setting][16]" />
		<?php endif;?>
	</td>
</tr>

</table>


<table  class="settinggroup">
<tr>
	<td colspan="2" class="settingtitle">Media instellingen</td>
</tr>	
<tr>
	<td class="alignright">
		<p>Thumbnail grootte:</p>
	</td>
	<td>
		<input type="text" name="data[Setting][5]" value="<?php echo $settings[4]['Setting']['pair']?>" class="small_text">
	</td>
</tr>
<tr>
	<td class="alignright">
		<p>Middel grootte:</p>
	</td>
	<td>
		<input type="text" name="data[Setting][6]" value="<?php echo $settings[5]['Setting']['pair']?>" class="small_text">
	</td>
</tr>

</table>


<table class="settinggroup">
	<tr>
		<td colspan="2" class="settingtitle">Admin instellingen</td>
	</tr>
	<tr>
		<td class="alignright">
			<p>Geavanceerde<br/>modus:</p>
		</td>
		<td>
			<?php if($settings[3]['Setting']['pair'] == 'true'):?>
				<input type="checkbox" name="data[Setting][4]" checked />
			<?php else:?>
				<input type="checkbox" name="data[Setting][4]" />

			<?php endif;?>
		</td>
	</tr>

	<tr>
		<td class="alignright">
			<p>Paginering:</p>
		</td>
		<td>
			<input type="text" name="data[Setting][11]" value="<?php echo $settings[9]['Setting']['pair']?> objecten per pagina" class="small_text">
		</td>
	</tr>
</table>



<table  class="settinggroup">
<tr>
	<td colspan="2" class="settingtitle">
		Statistieken<br/>
		<small>(Statistieken maakt gebruik van Google Analytics)</small>
	</td>
</tr>	
<tr>
	<td class="alignright">
		<p>Google gebruikersnaam:</p>
	</td>
	<td>
		<input type="text" name="data[Setting][7]" value="<?php echo $settings[6]['Setting']['pair']?>" class="small_text">
	</td>
</tr>
<tr>
	<td class="alignright">
		<p>Google wachtwoord:</p>
	</td>
	<td>
		<input type="password" name="data[Setting][8]" value="<?php echo $settings[7]['Setting']['pair']?>" class="small_text">
	</td>
</tr>
<tr>
	<td class="alignright">
		<p>Analytics id:</p>
	</td>
	<td>
		<input type="text" name="data[Setting][9]" value="<?php echo $settings[8]['Setting']['pair']?>" class="small_text">
	</td>
</tr>
<tr>
	<td colspan="2" style="text-align:center"><small>Uw Analytics ID kunt u vinden in de adresbalk (kopieer alleen de cijfers):</small></td>
</tr>
<tr>
	<td colspan="2"><img src="<?php echo HOME?>/img/ga.jpg" /></td>
</tr>
</table>

<div id="settingsbutton">
	<a href="#" class="pill giant button" onclick="submitForm('Setting', 'none')">Opslaan</a>
</div>
</form>
</div>