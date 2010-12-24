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
<div id="confirmation_dialog"> </div>
<div id="content" class="flex">
  <h1>Orders</h1> 
  <div id="content-main">
    <div class="module" id="changelist">
      <div id="toolbar">
        <?php 
          $this->Order->searchWidget(
            'mark_as_paid', $delivery_dates, $nextDelivery, $this->params['url'], '/coordinator/orders/mark_as_paid'); 
        ?>
      </div>          
    <table cellspacing="0">
      <thead>
        <tr>
          <th><?php echo $this->Paginator->sort('id');?></th>
          <th><?php echo $this->Paginator->sort('ordered_date');?></th>
          <th><?php echo $this->Paginator->sort('delivery_date', 'Delivery.date');?></th>
          <th><?php echo $this->Paginator->sort('Customer');?></th>
          <th><?php echo $this->Paginator->sort('Total Amount');?></th>
          <th><?php echo $this->Paginator->sort('paid');?></th>
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
    	<?php 
    	  App::import( 'Helper', 'Time' );
          $time = new TimeHelper;
        ?>
        <td>
          <?php echo $this->Time->format($format = 'd-m-Y H:i:s', $order['Order']['ordered_date'], null, "+7.0"); ?>&nbsp;
        </td>
        <td>
          <?php echo $time->format($format = 'd-m-Y', $order['Delivery']['date'], null, "+7.0"); ?>&nbsp;
        </td>
        <td>
          <?php 
            echo $this->Html->link($order['User']['name'], 
                                  array('controller' => 'users', 'action' => 'view', $order['User']['id'])); 
          ?>
        </td>
        <td>
    	  <?php 
    	    setlocale(LC_MONETARY, 'th_TH');
    	    echo money_format("&#3647 %i", $order['Order']['total']);
    	  ?>
        </td>
        <td>
          <?php echo $form->create('UpdateStatus'); ?>
          <?php echo $form->hidden('id', array('value' => $order['Order']['id']))?>
    	  <?php
    	    if($order['Order']['status'] == "entered"){
              echo $form->checkbox('status', array('value' => "1", 'class' => 'paid'));
          }
    	    if($order['Order']['status'] == "paid" || $order['Order']['status'] == "packed" || 
    	       $order['Order']['status'] == "delivered"){
              echo $form->checkbox('status', array('value' => "1", 'checked' => true, 'class' => 'paid'));
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
