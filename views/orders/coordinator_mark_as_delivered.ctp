<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('orders/coordinator_mark_as_delivered.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>

<div class="breadcrumbs">
  <?php 
    e($html->link('Home', '/coordinator')); 
  ?> &rsaquo; 
  Mark Orders as delivered
</div>
<div id="confirmation_dialog"></div>
<div id="content" class="flex">
  <h1>Orders</h1> 
  <div id="content-main">
    <div class="module" id="changelist">
      <div id="toolbar">
        <?php 
    	    e($form->create(null, array('type' => 'get', 
    	                                'action' => 'mark_as_delivered'))); 
    	  ?>
      <div><!-- DIV needed for valid HTML -->
      <label for="searchbar">
        <?php echo $html->image('admin/icon_searchbox.png')?>
      </label>
      <?php e($form->label('orderId')); ?> 
      <?php 
        if (isset($default_order_id)) {
          e($form->text('id', array('value' => $default_order_id, 
                                    'size' => '10')));
        } else {
          e($form->text('id', array('size' => '10')));
        }
      ?>
       &nbsp;&nbsp;
    	<?php e($form->label('customer name')); ?>  
    	<?php
    	  if (isset($default_customer_name)) {
    	    e($form->text('user_name', array('value' => $default_customer_name, 
    	                                      'size' => '40')));
    	  } else {
    	    e($form->text('user_name', array('size' => '40')));
    	  }
    	?>
       &nbsp;&nbsp;
      Delivery Date
      <?php 
        if (isset($default_delivery_id)) {
          e($form->select('delivery_date', $delivery_dates, 
                          array('selected' => $default_delivery_id), 
                          array('empty' => false))); 
        } else {
          e($form->select('delivery_date', $delivery_dates, NULL, 
                          array('empty' => false))); 

        }
      ?>
       &nbsp;&nbsp;
    	<?php e($form->submit('Search', array('div' => false))); ?>
    	 &nbsp;&nbsp;
    	<?php e($html->link('View All',
    	                    '/coordinator/orders/mark_as_delivered'))?>    	                                      
    </div>
    </form>
    </div>          
<table cellspacing="0">
  <thead>
    <tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('ordered_date');?></th>
			<th><?php echo $this->Paginator->sort('delivery_date');?></th>
			<th><?php echo $this->Paginator->sort('Customer');?></th>
			<th><?php echo $this->Paginator->sort('Total Amount');?></th>
			<th><?php echo $this->Paginator->sort('delivered');?></th>
			<th><?php __('Actions');?></th>
   </tr>
  </thead>
<tbody>
  	<?php
  	$i = 0;
  	foreach ($orders as $order):
  		$class = null;
  		if ($i++ % 2 == 0) {
  			$class = ' class="row1"';
  		} else {
  		  $class = ' class="row2"';
  		}
  	?>
    	<tr<?php echo $class;?>>
    		<td><?php echo $order['Order']['id']; ?>&nbsp;</td>
    		<td><?php echo $order['Order']['ordered_date']; ?>&nbsp;</td>
    		<td><?php echo $order['Delivery']['date']; ?>&nbsp;</td>
    		<td>
    			<?php echo $this->Html->link($order['User']['name'], array('controller' => 'users', 'action' => 'view', $order['User']['id'])); ?>
    		</td>
    		<td>
    		  <?php 
    		    setlocale(LC_MONETARY, 'th_TH');
    		    echo money_format("&#3647 %i", $order['Order']['total_supplied']);
    		  ?>
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

    		<td>
    			<?php echo $this->Html->link(__('View Details', true), array('action' => 'view', $order['Order']['id'])); ?>
    		</td>
    	</tr>
    <?php endforeach; ?>

</tbody>
</table>


	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<p class="paginator">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
          
      
      


      </form>
    </div>

  </div>

        
        <br class="clear" />
    </div>
