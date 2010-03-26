<div class="products form">
<?php echo $this->Form->create('Product');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Product', true)); ?></legend>
	<?php
		echo $this->Form->input('short_description');
		echo $this->Form->input('selling_price');
		echo $this->Form->input('image');
		echo $this->Form->input('quantity');
		echo $this->Form->input('stock');
		echo $this->Form->input('display');
		echo $this->Form->input('long_description');
		echo $this->Form->input('buying_price');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Products', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Line Items', true)), array('controller' => 'line_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Line Item', true)), array('controller' => 'line_items', 'action' => 'add')); ?> </li>
	</ul>
</div>