<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('util.js', false); ?>
<?php echo $javascript->link('grid.locale-en.js', false); ?>
<?php echo $javascript->link('jquery.jqGrid.min.js', false); ?>
<?php echo $javascript->link('jquery.blockUI.js', false); ?>
<?php echo $javascript->link('orders/supplier_close_batch.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>
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
  Close Batch
</div>

<div id="content" class="flex">
  <h1>Close Batch</h1> 
  <div id="content-main">
    <div class="module" id="changelist">

<table id="delivery_dates"></table>
<div id="delivery_dates_pager"></div>

<br/>

</div>
</div>
</div>
