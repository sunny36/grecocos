<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('orders/coordinator_mark_as_paid.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>

<div class="breadcrumbs">
  <?php 
   e($html->link('Home', '/coordinator')); 
  ?>
  &rsaquo;
  Mark orders as paid
</div>
<div id="confirmation_dialog"></div>
<div id="content" class="flex">
  <h1>Orders</h1> 
  <div id="content-main">
    <div class="module" id="changelist">
      <div id="toolbar">
        <?php 
    	    e($form->create(null, array('type' => 'get', 
    	                                'action' => 'mark_as_paid'))); 
    	  ?>
      <div><!-- DIV needed for valid HTML -->
      <label for="searchbar">
        <?php echo $html->image('admin/icon_searchbox.png')?>
      </label>
      <?php e($form->label('orderId')); ?> 
      <?php e($form->text('id', array('size' => '10'))); ?>
       &nbsp;&nbsp;
    	<?php e($form->label('customer name')); ?>  
    	<?php e($form->text('user_name', array('size' => '40'))); ?>
       &nbsp;&nbsp;
       &nbsp;&nbsp;
    	<?php e($form->submit('Search', array('div' => false))); ?>
    	 &nbsp;&nbsp;
    	<?php e($html->link('View All', '/coordinator/orders/mark_as_paid'))?>
    	                                      
    </div>
    </form>
    </div>          
<table cellspacing="0">
  <thead>
  	<tr>
  	    <th><?php echo "No."; ?></th>
  			<th><?php echo $this->Paginator->sort('product_id');?></th>
  			<th><?php echo $this->Paginator->sort('# Ordered', 'quantity');?></th>
  			<th><?php echo $this->Paginator->sort('# Supplied', 'quantity_supplied');?></th>
  			<th><?php echo $this->Paginator->sort('Amount Retail', 'total_price_supplied');?></th>
  			<th><?php echo $this->Paginator->sort('Amount Wholesale', 'total2_price_supplied');?></th>
  			
  	</tr>
  </thead>
<tbody>
  	<?php
  	$i = 0;
  	foreach ($lineItems as $lineItem):
  		$class = null;
  		if ($i++ % 2 == 0) {
  			$class = ' class="row1"';
  		} else {
  		  $class = ' class="row2"';
  		}
  	?>
    	<tr<?php echo $class;?>>
    	  <td>1</td>
    	  <td><?php echo $lineItem['Product']['short_description']; ?></td>
    		<td><?php echo $lineItem['LineItem']['quantity']; ?>&nbsp;</td>
    		<td><?php echo $lineItem['LineItem']['quantity_supplied']; ?>&nbsp;</td>
    		<td><?php echo $lineItem['LineItem']['total_price_supplied']; ?>&nbsp;</td>
    		<td><?php echo $lineItem['LineItem']['quantity_supplied'] * $lineItem['Product']['buying_price']; ?>&nbsp;</td>
    		
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
