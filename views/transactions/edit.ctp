<div class="transactions form">
<?php echo $this->Form->create('Transaction');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Transaction', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Transaction.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Transaction.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Transactions', true)), array('action' => 'index'));?></li>
	</ul>
</div>