<div class="configurations form">
<?php echo $this->Form->create('Configuration');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Configuration', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('key');
		echo $this->Form->input('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Configuration.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Configuration.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Configurations', true)), array('action' => 'index'));?></li>
	</ul>
</div>