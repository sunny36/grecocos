<div class="transactions form">
<?php echo $this->Form->create('Transaction');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Transaction', true)); ?></legend>
	<?php
		echo $this->Form->input('type');
		echo $this->Form->input('user_id');
		echo $this->Form->input('order_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Transactions', true)), array('action' => 'index'));?></li>
	</ul>
</div>