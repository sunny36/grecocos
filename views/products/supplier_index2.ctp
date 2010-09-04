<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('admin/admin_index.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.2.custom.min', false); ?>
<?php echo $javascript->link('grid.locale-en.js', false); ?>
<?php echo $javascript->link('jquery.jqGrid.min.js', false); ?>
<?php echo $javascript->link('products/supplier_products.js', false); ?>
<?php echo $html->css('jquery-ui/redmond/jquery-ui-1.8.2.custom',null, array('inline' => false)); ?>
<?php echo $html->css('ui.jqgrid', null, array('inline' => false)); ?>
<style text="type/css">
  input[type="button"] {
  padding: 0em; 

  }
</style>

<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', '/supplier'));
  ?> 
  &rsaquo; 
  Products
</div>
<!-- End Navigation  -->

<div id="content" class="flex">
  <div id="content-main">
    <!-- <div class="module" id="changelist"> -->
      <table id="products"></table>
    <!-- </div> -->
  </div>
</div>
