<div class="products form">
<?php echo $form->create('Product');?>
	<fieldset>
 		<legend><?php __('Edit Product');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('image');
		echo $form->input('name');
		echo $form->input('description');
		echo $form->input('price');
		echo $form->input('sendcost');
		echo $form->input('Fabrick');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Product.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Product.id'))); ?></li>
		<li><?php echo $html->link(__('List Products', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Fabricks', true), array('controller'=> 'fabricks', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Fabrick', true), array('controller'=> 'fabricks', 'action'=>'add')); ?> </li>
	</ul>
</div>
