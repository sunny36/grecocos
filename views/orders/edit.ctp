<div class="orders view">
<h2><?php  __('Order');?></h2>
  <?php echo $this->Form->create('Order');?>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ordered Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['ordered_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php 
      $options = array($order['Order']['status'] =>                 
                        ucwords($order['Order']['status']));
      if ($options[$order['Order']['status']] != 'Entered') {
        $options['entered'] = 'Entered';
      }

      if ($options[$order['Order']['status']] != 'Paid') {
        $options['paid'] = 'Paid';
      }
      if ($options[$order['Order']['status']] != 'Delivered') {
        $options['delivered'] = 'Delivered';
      }
    ?>  
    <?php echo $this->Form->select('status', $options); ?>
    &nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Completed'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		  <div class="input checkbox">
			<?php echo $this->Form->checkbox('complete') ?>
      &nbsp;
      </div>
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Customer'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
			  echo $this->Html->link($order['User']['name'], 
			                         array('controller' => 'users', 
			                               'action' => 'view', 
			                         $order['User']['id'])); 
			?>
			&nbsp;
		</dd>
	</dl>
	<?php echo $this->Form->end(__('Submit', true));?>
</div>

<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
    <li>
      <?php 
        e($this->Html->link(__('Delete This Order', true), 
  		                      array('action' => 'delete', 
  		                      $this->Form->value('Order.id')), null, 
  		                      sprintf(__('Are you sure you want to delete # %s?', 
  		                      true), 
  		                      $this->Form->value('Order.id')))); 
  		?>
		</li>
		<li>
		  <?php e($this->Html->link(sprintf(__('List All %s', true), 
		                            __('Orders', true)),
		                            array('action' => 'index')));?>
		</li>
	</ul>
</div>