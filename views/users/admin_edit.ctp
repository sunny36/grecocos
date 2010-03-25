<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php printf(__('Admin Edit %s', true), __('User', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('email');
		echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
		echo $this->Form->input('middlename');
		echo $this->Form->input('address1');
		echo $this->Form->input('address2');
		echo $this->Form->input('address3');
		echo $this->Form->input('city');
		echo $this->Form->input('postalcode');
		echo $this->Form->input('phone');
	?>
	<?php 
    $options=array($this->Form->value('User.status') => ucwords($this->Form->value('User.status')));
    if ($options[$this->Form->value('User.status')] != 'Accepted') {
      $options['accepted'] = 'Accepted';
    }
    
    if ($options[$this->Form->value('User.status')] != 'Deleted') {
      $options['deleted'] = 'Deleted';
    }
    if ($options[$this->Form->value('User.status')] != 'Registered') {
      $options['registered'] = 'Registered';
    }
  ?>  
  <div class="input select">
    <?php
      echo $form->label('status');
		  echo $this->Form->select('status', $options); 
		?>
	</div>

	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('action' => 'index'));?></li>
	</ul>
</div>