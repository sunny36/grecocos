<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('orders.js', false); ?>

<div class="orders index">
	<h2><?php __('Orders');?></h2>
	<?php 
	  e($form->create(null, array('type' => 'get', 'action' => 'index'))); 
	  e($form->label('order Id'));
	  e($form->text('id'));
	  e($form->end('Search'));
	?>
	<?php 
	  e($form->create(null, array('type' => 'get', 'action' => 'index'))); 
	  e($form->label('customer name'));
	  e($form->text('user_name'));
	  e($form->end('Search'));
	?>	  
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('ordered_date');?></th>
			<th><?php echo $this->Paginator->sort('Customer');?></th>
			<th><?php echo $this->Paginator->sort('Total Amount');?></th>
			<th><?php echo $this->Paginator->sort('paid');?></th>
			<th><?php echo $this->Paginator->sort('delivered');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($orders as $order):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $order['Order']['id']; ?>&nbsp;</td>
		<td><?php echo $order['Order']['ordered_date']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($order['User']['name'], array('controller' => 'users', 'action' => 'view', $order['User']['id'])); ?>
		</td>
		<td><?php echo $order['Order']['total']?></td>
		<td>
		  <?php echo $form->create('UpdateStatus'); ?>
		  <?php echo $form->hidden('id', array('value' => $order['Order']['id']))?>
		  <?php
		    if($order['Order']['status'] == "entered"){
		      echo $form->checkbox('status', 
		                           array('value' => "1", 'class' => 'paid'));
		    }
		    if($order['Order']['status'] == "paid"){
		      echo $form->checkbox('status', 
		                           array('value' => "1", 
		                                 'checked' => true,
		                                 'class' => 'paid'));
		    }
		    if($order['Order']['status'] == "delivered"){
		      echo $form->checkbox('status', 
		                           array('value' => "1", 
		                                 'checked' => true,
		                                 'class' => 'paid'));
		    }
		    
		  ?>
		  <?php echo $form->end(); ?>
		  
		  &nbsp;
		</td>
		<td>
		  <?php echo $form->create('UpdateStatus'); ?>
		  <?php echo $form->hidden('id', array('value' => $order['Order']['id']))?>
		  <?php
		    if($order['Order']['status'] == "delivered"){
		      echo $form->checkbox('status', 
		                           array('value' => "1", 
		                                 'checked' => true,
		                                 'class' => 'delivered'));
		    }
		    else {
		      echo $form->checkbox('status', 
		                           array('value' => "1", 'class' => 'delivered'));
		    }
		  ?>
		  <?php echo $form->end(); ?>
		  
		  &nbsp;
		</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $order['Order']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
</div>