<div class="lineItems form">
<?php echo $this->Form->create('LineItem');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Line Item', true)); ?></legend>
	<?php
		echo $this->Form->input('product_id');
		echo $this->Form->input('order_id');
		echo $this->Form->input('quantity');
		echo $this->Form->input('total_price');
		echo $this->Form->input('total_price_supplied');
		echo $this->Form->input('quantity_supplied');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Line Items', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Products', true)), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Product', true)), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Orders', true)), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Order', true)), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>