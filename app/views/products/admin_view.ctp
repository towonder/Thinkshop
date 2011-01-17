<div class="products view">
<h2><?php  __('Product');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['image']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['price']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sendcost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['sendcost']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Product', true), array('action'=>'edit', $product['Product']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Product', true), array('action'=>'delete', $product['Product']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Products', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Fabricks', true), array('controller'=> 'fabricks', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Fabrick', true), array('controller'=> 'fabricks', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Fabricks');?></h3>
	<?php if (!empty($product['Fabrick'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Image'); ?></th>
		<th><?php __('Add'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($product['Fabrick'] as $fabrick):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $fabrick['id'];?></td>
			<td><?php echo $fabrick['name'];?></td>
			<td><?php echo $fabrick['image'];?></td>
			<td><?php echo $fabrick['add'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'fabricks', 'action'=>'view', $fabrick['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'fabricks', 'action'=>'edit', $fabrick['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'fabricks', 'action'=>'delete', $fabrick['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $fabrick['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Fabrick', true), array('controller'=> 'fabricks', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
