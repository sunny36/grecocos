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
  <h1>Order</h1>
  <div id="content-main">
    
    <div>
      <?php echo $session->flash(); ?>
      <fieldset class="module aligned ">
        <!-- Begin Id  -->
        <div class="form-row id">
          <div>
            <?php e($form->label('id', "Order Id")); ?>        
            <strong> <?php e($order['Order']['id']); ?></strong>
          </div>        
        </div><!-- div form-row id -->
        <!-- End Id  -->
    
        <!-- Begin Order Date  -->
        <div class="form-row order_date">
          <div>
            <?php e($form->label('ordered_date', "Order Date")); ?>        
            <strong> <?php e($order['Order']['ordered_date']); ?></strong>
          </div>        
        </div> 
        <!-- End Order Date  -->

        <!-- Begin Order Status  -->
        <div class="form-row status">
          <div>
            <?php e($form->label('status', "Status")); ?>        
            <strong> <?php e($order['Order']['status']); ?></strong>
          </div>        
        </div>
        <!-- End Order Status  -->

        <!-- Begin Order Total  -->
        <div class="form-row total">
          <div>
            <?php e($form->label('status', "Status")); ?>        
            <strong> <?php e($order['Order']['total']); ?></strong>
          </div>        
        </div>
        <!-- End Order Total  -->

        <!-- Begin Order Customer  -->
        <div class="form-row customer">
          <div>
            <?php e($form->label('customer', "Customer")); ?>        
            <strong>
              <?php e($html->link($order['User']['name'], 
                      array('controller' => 'users', 'action' => 'view', 
                            $order['User']['id'], 'admin' => true)))?>
            </strong>
          </div>        
        </div>
        <!-- End Customer  -->
      </fieldset>
    </div>
    <h1>Order Details</h1>
    <table id="order"></table>
    <div id="order_pager"></div>
  </div>
</div>
