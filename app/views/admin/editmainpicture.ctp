<?php

	if($type == 'product'){
		$object_id = $object['Product']['id'];
	}


?>


<script type="text/javascript">
		

	function addMainImage(string){
		var id = string.substr(6);
		
		$.ajax({ 
			url: "<?php echo HOME?>/admin/savemainpicture/"+id+"/<?php echo $object_id?>/<?php echo $type?>",
	  		success: function(data) {
				if(data != ''){
					$('#mainimgimg').fadeOut('fast');
					$('#mainimgimg').attr('src', data);
					$('#mainimgimg').fadeIn('fast');
				}
			}
		});
	};
		
	function closeBox(){
		parent.$.fancybox.close();
	}
	

</script>
<div id="mainimagetop">
	<div id="mainimagedrop">
	<?php if(!empty($object['Image']['large'])):?>
		<img src="<?php echo HOME . $object['Image']['thumb']?>" width="60px" id="mainimgimg">
	<?php else: ?>
		<img src="<?php echo HOME?>/img/no_picture_thumb.png" height="60px" id="mainimgimg">
	<?php endif;?>
	</div>
	
	<h2>Nieuwe hoofdafbeelding</h2>

	<a href="#" class="pillgiant button" onclick="closeBox()" style="margin-right:25px;">Opslaan</a>
	
</div>


<div id="mainphotolibrary" >
	<div class="description_text" style="border:1px solid #cccccc;border-top:0px;margin-bottom:15px">Fotobibliotheek</div>
	
	<div id="photosinlibrary">
		<table cellspacing="0" cellpadding="0">
	<?php $i = 0; ?>
		<?php foreach($photos as $photo):

			if($photo['Photo']['id'] != $object['Product']['photo_id']):
					
				$class = ' class="row"';
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
					
					
		?>
			<tr <?php echo $class?> id="photo_<?php echo $photo['Photo']['id']?>" onClick="addMainImage('photo_<?php echo $photo['Photo']['id']?>');" style="width:650px">
				<td <?php echo $class?>>
					<img src="<?php echo HOME . $photo['Photo']['thumb']?>"/>
				</td>
				<td <?php echo $class?>>
					<p><?php echo $photo['Photo']['name']?></p>
					<small><?php echo date('d-m-Y', strtotime($photo['Photo']['created'])); ?></small>
				</td>
				<td <?php echo $class?>>
					<b>Voeg toe</b>
				</td>
			</tr>
			<?php endif;?>
		<?php endforeach;?>
		</table>
	</div>
			
</div>
