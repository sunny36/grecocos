<?php echo $javascript->link('jquery-ui-1.8.2.custom.min', false); ?>
<?php echo $javascript->link('jquery.url', false); ?>
<?php echo $javascript->link('json2', false); ?>
<?php echo $javascript->link('util', false); ?>
<?php echo $javascript->link('grid.locale-en.js', false); ?>
<?php echo $javascript->link('jquery.jqGrid.min.js', false); ?>
<?php echo $javascript->link('util.js', false); ?>
<?php echo $javascript->link('admin/admin_index.js', false); ?>
<?php echo $javascript->link('deliveries/supplier_index.js', false); ?>
<?php echo $html->css('jquery-ui/redmond/jquery-ui-1.8.2.custom',null, array('inline' => false)); ?>
<?php echo $html->css('ui.jqgrid', null, array('inline' => false)); ?>

<style>
  input[type="button"] {
  padding: 0em; 

  }
</style>
<div class="breadcrumbs">
  <?php echo $html->link('Home', '/supplier'); ?> &rsaquo; Delivery Dates
</div>
<div id="content" class="flex">
  <h1> Delivery Dates</h1> 
  <div id="content-main" style="width: auto !important">
    <ul class="object-tools">
      <li>
        <?php 
          echo $html->link(
            'Add Delivery Date', array('controller' => 'deliveries', 'action' => 'add'), 
            array('class' => 'addlink')
          );
        ?>
      </li>
    </ul>    <!-- object-tools -->
    <?php echo $session->flash(); ?>     
    <table id="delivery_dates"></table>
  </div>
  <br class="clear" />
</div>
