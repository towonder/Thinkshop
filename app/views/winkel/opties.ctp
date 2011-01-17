<script type="text/javascript">

	function submitForm(){
		$('#selectOptions').submit();
	}

</script>

<div id="options">
<form id="selectOptions" action="<?php echo HOME?>/winkel/opties/<?php echo $product['Product']['id']?>" method="post">

<?php if(!empty($product['Children'])):?>
<h2 style="width:600px;text-align:center">Selecteer een variant:</h2>
	<table>
		<tr>
			<th></th>
			<th>Variatie</th>
			<th>Selecteer</th>
		<tr>
		<?php $o = 1; ?>
		<?php foreach($product['Children'] as $child): ?>
		<tr>
			<td><img src="<?php echo HOME . $child['Image']['thumb']?>" width="70px" /></td>
			<td><?php echo $product['Product']['name'] .' - '. $child['name']?></td>
			<td><input type="radio" name="data[child_id]" value="<?php echo $child['id']?>" /></td>
		</tr>
		<?php endforeach;?>
		
	</table>
<?php endif;?>


	
<?php if(!empty($product['Options'])):?>	
<?php foreach($product['Options'] as $option):?>
<h2 style="width:600px;text-align:center">Selecteer uw <?php echo $option['name']?>:</h2>
<?php
	
	$icon = 'false';
	$multiselect = 'false';

	if($option['icon'] == true){
		$icon = 'true';
	}
	
	if($option['multiselect'] == true){
		$multiselect = 'true';
	}

?>
<table>
	<tr>
	<?php foreach($option['Values'] as $value): ?>
		<td>
			<?php echo $value['name']?>
		</td>
	<?php endforeach; ?>
	</tr>
	<tr>
	<?php foreach($option['Values'] as $value):?>
		<td>
		<input type="hidden" name="data[Metavalue][<?php echo $option['id']?>][id]" value="<?php echo $option['id']?>">
		<input type="hidden" name="data[Metavalue][<?php echo $option['id']?>][icon]" value="<?php echo $icon?>"/>
		<input type="hidden" name="data[Metavalue][<?php echo $option['id']?>][multiselect]" value="<?php echo $multiselect?>">
		<?php if($option['icon'] == false):?>
			<?php if($option['multiselect'] == false):?>
			<input type="radio" name="data[Metavalue][<?php echo $option['id']?>][select]" value="<?php echo $value['id']; ?>" />
			<?php else:?>
			<input type="checkbox" name="data[Metavalue][<?php echo $option['id']?>][select]" value="<?php echo $value['id']?>"/>
			<?php endif; ?>
		<?php else: ?>
		
		
		<?php endif; ?>
		</td>
	<?php endforeach; ?>
</table>
<?php endforeach; ?>
<?php endif;?>
<table style="text-align:right">
	<tr>
		<td>
			<img src="<?php echo HOME?>/img/frontside/continuecart.jpg" onclick="submitForm();" style="cursor:pointer">
		</td>
	</tr>
</table>
</form>
</div>