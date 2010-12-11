<div class="organizations form">
<?php echo $this->Form->create('Organization');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Organization', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('delivery_address');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Organization.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Organization.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Organizations', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>