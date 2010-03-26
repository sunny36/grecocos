<div class="deliveries form">
<?php echo $this->Form->create('Delivery');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Delivery', true)); ?></legend>
	<?php
		echo $this->Form->input('date');
		echo $this->Form->input('next_delivery');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Deliveries', true)), array('action' => 'index'));?></li>
	</ul>
</div>