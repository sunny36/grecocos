<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('grid.locale-en.js', false); ?>
<?php echo $javascript->link('jquery.jqGrid.min.js', false); ?>
<?php echo $javascript->link('util.js', false); ?>
<?php echo $javascript->link('deliveries/payments.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom', null, 
  array('inline' => false)); ?>
<?php echo $html->css('ui.jqgrid', null, array('inline' => false)); ?>
<!-- TODO Extract to external style sheet -->
<style text="type/css">
  input[type="button"] {
  padding: 0em; 

  }
</style>

<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', '/coordinator')); 
  ?>
   &rsaquo; 
  Payments
</div>
<!-- End Navigation  -->


<div id="content" class="flex">
  <h1>Payments</h1> 
  <div id="content-main">
    <div class="module" id="changelist">
      <br/>
      <table id="deliveries"></table>
      <div id="deliveries_pager"></div>
      <br/>
    </div>
  </div>
</div>
        



