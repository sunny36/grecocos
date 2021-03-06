<?php echo $javascript->link('jquery-ui-1.8.2.custom.min', false); ?>
<?php echo $javascript->link('jquery.blockUI', false); ?>
<?php echo $javascript->link('util', false); ?>
<?php echo $javascript->link('orders/supplier_products_orders', false); ?>
<?php echo $html->css('jquery-ui/redmond/jquery-ui-1.8.2.custom',null, array('inline' => false)); ?>
<div class="breadcrumbs">
  <?php 
   e($html->link('Home', '/supplier')); 
  ?>
  &rsaquo;
  Swift Products in row | Orders in column Report
</div>

<div id="confirmation_dialog"></div>
<div id="content" class="flex">
  <h1>Swift Products in row | Orders in column Report</h1> 
  <?php echo $session->flash(); ?>
  <div id="content-main" style="width: auto !important">
    <div class="module" id="changelist">
      <div id="toolbar">
        <?php e($form->create(null, array('type' => 'get', 'action' => 'products_orders'))); ?>
      <div><!-- DIV needed for valid HTML -->
      <label for="searchbar">
        <?php echo $html->image('admin/icon_searchbox.png')?>
      </label>
        Outlet
        <?php 
          if (isset($this->params['url']['organizations'])) {
            echo $form->select(
              'organizations', $organizations, array('selected' => $this->params['url']['organizations'])
            ); 
          } else {
            echo $form->select('organizations', $organizations, NULL); 
          }
        ?>
        &nbsp;&nbsp;
        <span id="delivery_date_span">
          <label id="delivery_date_label">Delivery Date</label>
          <?php 
            if (isset($default_delivery_id)) {
              e($form->select('delivery_date', $delivery_dates, 
                              array('selected' => $default_delivery_id))); 
            } else {
              e($form->select('delivery_date', $delivery_dates, NULL)); 

            }
          ?>
         </span>
       &nbsp;&nbsp;
    	<?php e($form->submit('Download Report', array('div' => false, 'id' => 'download_report'))); ?>
    	 &nbsp;&nbsp;
    	                                      
    </div>
    </form>
    </div>          
    </div>
  </div>        
        <br class="clear" />
    </div>
