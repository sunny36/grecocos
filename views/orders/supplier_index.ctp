<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('grid.locale-en.js', false); ?>
<?php echo $javascript->link('jquery.jqGrid.min.js', false); ?>
<?php echo $javascript->link('supplier_orders.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>
<?php echo $html->css('ui.jqgrid', null, array('inline' => false)); ?>

<p>Click anywhere on the row to view the details of the order.</p>
<table id="orders"></table>
<div id="orders_pager"></div>

<br/>

<table id="order_d"></table>
<div id="order_d_pager"></div>
