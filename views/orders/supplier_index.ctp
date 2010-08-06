<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.2.custom.min', false); ?>
<?php echo $javascript->link('grid.locale-en.js', false); ?>
<?php echo $javascript->link('jquery.jqGrid.min.js', false); ?>
<?php echo $javascript->link('orders/supplier_orders.js', false); ?>
<?php echo $html->css('jquery-ui/redmond/jquery-ui-1.8.2.custom',null, array('inline' => false)); ?>

<?php echo $html->css('ui.jqgrid', null, array('inline' => false)); ?>
<!-- TODO Extract to external style sheet -->
<style text="type/css">
  input[type="button"] {
  padding: 0em; 

  }
</style>
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', '/supplier')); 
  ?> &rsaquo; 
  Orders
</div>

<div id="content" class="flex">
  <div id="content-main">
    <!-- <div class="module" id="changelist"> -->
      <table id="orders"></table>
      <div id="orders_pager"></div>

      <br/>

      <table id="order_d"></table>
      <div id="order_d_pager"></div>
    <!-- </div> -->
  </div>
</div>
