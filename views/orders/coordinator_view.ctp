<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('grid.locale-en.js', false); ?>
<?php echo $javascript->link('jquery.jqGrid.min.js', false); ?>
<?php echo $javascript->link('order.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>
<?php echo $html->css('ui.jqgrid', null, array('inline' => false)); ?>



<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php e($html->link('Home', array('controller' => 'dashboard', 
                                'action' => 'index', 'admin' => true))); ?> 
  &rsaquo; 
  <?php e($html->link('Order', array('controller' => 'orders', 
                                'action' => 'index', 'admin' => true))); ?> 
  &rsaquo;                            
  Order
</div><!-- breadcrumbs -->
<!-- End Navigation  -->

<div id="content" class="colM">
  <h1>Order #<?php e($order['Order']['id']); ?></h1>
  <div id="content-main">
    
    <div>
      <?php echo $session->flash(); ?>
    </div>
    
 
 <table>
   <tr>
     <td><?php e($form->label('id', "Order Id")); ?></td>
     <td> <strong> <?php e($order['Order']['id']); ?></strong> </td>
     <td><?php e($form->label('customer', "Customer")); ?></td>
     <td><strong>
       <?php e($html->link($order['User']['name'], 
               array('controller' => 'users', 'action' => 'view', 
                     $order['User']['id'], 'admin' => true)))?>
     </strong>
     </td>
   </tr>
   <tr>
     <td><?php e($form->label('ordered_date', "Ordered Date")); ?></td>
     <td> <strong> <?php e($order['Order']['ordered_date']); ?></strong> </td>
     <td><?php e($form->label('delivery_date', "Delivery Date")); ?></td>
     <td> <strong> <?php e($order['Delivery']['date']); ?></strong> </td>     
   </tr>
 </table>
  	
    <table id="order"></table>
    <div id="order_pager"></div>
  </div>
</div>

