<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('jquery.blockUI.js', false); ?>
<?php echo $javascript->link('orders/send_payment_reminder_email.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>

<div class="breadcrumbs">
  <?php 
   e($html->link('Home', '/coordinator')); 
  ?>
  &rsaquo;
  Send Payment Reminder Email
</div>

<div id="confirmation_dialog"></div>
<div id="content" class="flex">
  <h1>Send Payment Reminder Email</h1> 
        <?php echo $session->flash(); ?>
  <div id="content-main" style="width: auto !important">
<h4>Payment reminder emails will be sent to the following: </h4>
    <div class="module" id="changelist">
<?php if(isset($orders)): ?>
<table cellspacing="0">
  <thead>
    <tr>
      <th>Order Id</th>
			<th>Customer</th>
			<th>Amount</th>
			<th>Ordered Date/Time</th>
   </tr>
  </thead>
<tbody>
  <?php
    App::import( 'Helper', 'Time' );
    $time = new TimeHelper;    
  ?>
  
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
    		    echo money_format("&#3647 %i", $order['Order']['total_supplied']);
    		  ?>
    		</td>
    		<td>
    		  <?php 
    		    echo $time->format(
    		      $format = 'd-m-Y H:i:s', $order['Order']['ordered_date'], 
    		      NULL, "+7.0"); 
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
      e($form->end(array('label' => 'Send', 'id' => 'send', 'div' => array('class' => false))));
    ?>

  </div>
<?php endif; ?>          
      
      


      </form>
    </div>

  </div>

        
        <br class="clear" />
    </div>
