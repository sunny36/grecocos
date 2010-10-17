<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('grid.locale-en.js', false); ?>
<?php echo $javascript->link('jquery.jqGrid.min.js', false); ?>
<?php echo $javascript->link('transactions/index.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom', null, 
  array('inline' => false)); ?>
<?php echo $html->css('ui.jqgrid', null, array('inline' => false)); ?>
<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', '/coordinator')); ?> &rsaquo; 
    Cash Report 1
</div>
<!-- End Navigation  -->


<div id="content" class="flex">
  <h1>Transactions</h1> 
  <div id="content-main">
    <div class="module" id="changelist">
      <br/>
      <table id="transactions"></table>
      <div id="transactions_pager"></div>
      <br/>
    </div>
  </div>
</div>
        



