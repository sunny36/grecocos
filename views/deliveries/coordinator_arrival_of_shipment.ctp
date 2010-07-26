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
        <?php echo $session->flash(); ?>
  <div id="content-main" style="width: auto !important">
    <div class="module" id="changelist">
      <div id="toolbar">
        <?php 
    	    e($form->create(null, array('type' => 'get', 
    	                                'action' => 'arrival_of_shipment'))); 
    	  ?>
      <div><!-- DIV needed for valid HTML -->
      <label for="searchbar">
        <?php echo $html->image('admin/icon_searchbox.png')?>
      </label>
      Delivery Date
      <?php 
        if (isset($default_delivery_date)) {
          e($form->select('delivery_date', $delivery_dates, array('selected' => $default_delivery_date), 
                          array('empty' => false))); 

        } else {
          e($form->select('delivery_date', $delivery_dates, NULL, array('empty' => false))); 

        }
      ?>
       &nbsp;&nbsp;
    	<?php e($form->submit('Search', array('div' => false))); ?>
    	 &nbsp;&nbsp;
    	                                      
    </div>
    </form>
    </div>          
<?php if(isset($orders)): ?>
<table cellspacing="0">
  <thead>
    <tr>
      <th>Order Id</th>
			<th>Customer</th>
			<th>Amount</th>
   </tr>
  </thead>
<tbody>
  	<?php
  	foreach ($orders as $order):
  	?>
    	<tr>
    	  <td><?php echo $order['Order']['id']; ?></td>
    		<td>
    			<?php echo $this->Html->link($order['User']['name'], array('controller' => 'users', 'action' => 'view', $order['User']['id'])); ?>
    		</td>
    		<td>
    		  <?php 
    		    setlocale(LC_MONETARY, 'th_TH');
    		    echo money_format("&#3647 %i", $order['Order']['total']);
    		  ?>
    		</td>

    	</tr>
    <?php endforeach; ?>

</tbody>
</table>



	</div>
  <div class="submit-row" >
    <?php 
	    e($form->create(null, array('type' => 'post', 'action' => 'arrival_of_shipment'))); 
	    e($form->hidden('delivery_date', array('value' => $default_delivery_date ))); 
      e($form->end(array('label' => 'Email to All', 'div' => array('class' => false))));
    ?>

  </div>
<?php endif; ?>          
      
      


      </form>
    </div>

  </div>

        
        <br class="clear" />
    </div>
