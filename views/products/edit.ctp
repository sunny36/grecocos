<div class="products form">
<?php echo $this->Form->create('Product', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Product', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('short_description');
		echo $this->Form->input('long_description');
		echo $this->Form->input('selling_price');
		echo $this->Form->input('buying_price');
		echo $this->Form->input('quantity');
		echo $this->Form->input('stock');
		echo $this->Form->input('display');
		echo $this->Form->label('current image');
		e($html->image('/attachments/photos/small/' .               
		  $this->Form->value('image')));
		  e("<br/>");
		echo $this->Form->label('upload new image');
		echo $form->file('Attachment');
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Product.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Product.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Products', true)), array('action' => 'index'));?></li>
	</ul>
</div>