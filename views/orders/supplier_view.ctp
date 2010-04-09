<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>
<?php echo $html->css('ui.jqgrid', null, array('inline' => false)); ?>





<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('grid.locale-en.js', false); ?>
<?php echo $javascript->link('jquery.jqGrid.min.js', false); ?>
<?php echo $javascript->link('supplier_orders.js', false); ?>

<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li>
		  <?php e($this->Html->link(sprintf(__('List All %s', true), 
		                            __('Orders', true)),
		                            array('action' => 'index')));?>
		</li>
	</ul>
</div>

<div class="orders view">
<h2><?php  __('Order');?></h2>
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
    <?php echo ucwords($order['Order']['status']) ?>
    &nbsp;
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
</div>

<div class="orders_details view">
<h2><?php  __('Order Detail');?></h2>
  <table width="100%" cellpadding="0" cellspacing="0">
    <thead>
			<tr>
				<td>Qty</td>
				<td>Item Description</td>
				<td>Item Price</td>
				<td>Sub-Total</td>
			</tr>
		</thead>
		<?php $i = 0; $class = ' class="altrow"';?>
		<?php $total = 0; ?>
		<?php foreach($products as $product): ?>
		  <tr>
		    <td><?php e($product['LineItem']['quantity'])?></td>
		    <td><?php e($product['Product']['short_description'])?></td>
		    <td>&#3647; <?php e($product['Product']['selling_price'])?></td>
		    <td>&#3647; <?php e($product['LineItem']['total_price'])?></td>
		  </tr>
		  <?php $total += $product['LineItem']['total_price']; ?>
		  <?php endforeach ?>
		  <tr>
  			<td></td>
   		 	<td></td>
   		 	<td><strong>Total</strong></td>
   		 	<td>&#3647; <?php echo $total; ?></td>
  		</tr>
      
		
  </table>
  <table id="list4"></table>
</div>


