<?php if($page['Staticpage']['form'] == '0'):?>
	<div id="page">
		<?php echo $page['Staticpage']['body'];?>
	</div>
<?php else: ?>
	
	<?php
		
		
if($page['Staticpage']['location'] != ''):

		$loclink = $page['Staticpage']['location'];
		$location = explode(',', $loclink);
		$zoom = $page['Staticpage']['zoom'];
		
		$adres = $page['Staticpage']['street'] .'<br/>';
		$adres .= $page['Staticpage']['zipcode'] .' '. $page['Staticpage']['city'].'<br/>';
		$adres .= $page['Staticpage']['country'] .'<br/>';		
		
		$check = explode('<br>', $adres);
		
		$a = count($check);
		$h = ($a * 20) + 35;
		
		$street = str_replace(' ', '+', $page['Staticpage']['street']);
		$city = str_replace(' ', '+', $page['Staticpage']['city']);
		$country = str_replace(' ', '+', $page['Staticpage']['country']);
		
		$link = "http://maps.google.nl/maps?f=q&source=s_q&hl=nl&geocode=&q=".$street.",+".$city."+".$country."&aq=&sll=".$location[0].",".$location[1]."&sspn=0.007384,0.019441&ie=UTF8&hq=&hnear=".$street.",+".$city."&z=16&f=d";
		
		
	?>
	
<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false'></script>	
<script type="text/javascript" src="<?php echo HOME?>/js/locationpicker/gmap.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	
	$("#map").goMap({ 
		latitude: <?php echo $location[0] +.0002;?>, 
		longitude: <?php echo $location[1];?>,
		navigationControl: false, 
		mapTypeControl: false, 
		scrollwheel: false, 
		disableDoubleClickZoom: false,
		zoom: <?php echo $zoom; ?>
	});
	
	$.goMap.createMarker({
		latitude: <?php echo $location[0]?>,
		longitude: <?php echo $location[1]?>,
		icon:'<?php echo HOME?>/img/frontside/marker.png',
		html: { 
			content: 'Auto popup!', 
			id: '#adres',
			popup: true 
		}
	});
});

function doSubmitForm(){
	
	var email = $('#cemail').val();
	var captcha = $('#ccaptcha').val();
	
	$.ajax({ 
		url: "<?php echo HOME?>/winkel/contactcheck/"+email+"/"+captcha,
		success: function(data) {
			if(data == 'contact_okay'){
				$('#cform').submit();
			}else{
				$('#error').hide();
				$('#error').empty();
				$('#error').append(data);
				$('#error').fadeIn('slow');
			}
		}
	});		
}

</script>

<?php endif;?>
	
	
	<div id="adres" style="display:none">
		<div style="height:<?php echo $h?>px;overflow:hidden">
		<?php echo $adres; ?>
		<a href="<?php echo $link?>" target="_blank">Routebeschrijving &raquo;</a>
		</div>
	</div>
	
<div id="map">
</div>


<form name="contactform" action="<?php echo HOME?>/winkel/contactform" method="post" id="cform">
	<input type="hidden"  name="data[Contact][mail_to]" value="<?php echo $page['Staticpage']['mail_to']?>">
	
	<table cellspacing="0" cellpadding="0" id="formfields">
		<tr>
			<td></td>
			<td><div id="error"></div></td>
		</tr> 
		<tr>
			<td class="formlabel">Jouw naam:</td>
			<td class="forminput"><input type="text" name="data[Contact][naam]"></td>
		</tr>
		<tr>
			<td class="formlabel">Jouw e-mailadres:</td>
			<td class="forminput"><input type="text" name="data[Contact][email]" id="cemail"></td>
		</tr>
		<?php if($page['Staticpage']['use_captcha'] == '1'):?>
		<tr>
			<td class="formlabel"><img src="<?php echo HOME?>/img/frontside/captcha.jpg" /></td>
			<td class="forminput"><input type="text" name="data[Contact][captcha]" id="ccaptcha"></td>
		</tr>
		<?php endif; ?>
		<tr>
			<td  class="formlabel" valign="top">Jouw opmerking:</td>
			<td class="formarea">
				<textarea name="data[Contact][opmerking]"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<a href="#error" class="medium  button" style="margin-left:374px" onclick="doSubmitForm()"><span class="icon mail"></span> Verstuur</a>
			</td>
		</tr>
	
	</table>
	
	
	
</form>
	
<?php endif; ?>
