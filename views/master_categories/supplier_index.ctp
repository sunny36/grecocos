<?php echo $javascript->link('admin/admin_index', false); ?>
<?php echo $javascript->link('jquery.url', false); ?>
<?php echo $javascript->link('json2', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.2.custom.min', false); ?>
<?php echo $javascript->link('grid.locale-en.js', false); ?>
<?php echo $javascript->link('jquery.jqGrid.min.js', false); ?>
<?php echo $javascript->link('master_categories/index', false); ?>
<?php echo $html->css('jquery-ui/redmond/jquery-ui-1.8.2.custom',null, array('inline' => false)); ?>
<?php echo $html->css('ui.jqgrid', null, array('inline' => false)); ?>
<style text="type/css">
  input[type="button"] {
  padding: 0em; 

  }
</style>

<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php e($html->link('Home', '/supplier')); ?> 
   &rsaquo; 
  Product Categories
</div>
<!-- End Navigation  -->

<div id="content" class="flex">
  <br/><br/>
  <div id="content-main" style="width: auto !important">
    <ul class="object-tools">
      <li>
        <?php echo $html->link('Add  Master Category', 
          array('controller' => 'master_categories',                                               
                'action' => 'add'), 
        array('class' => 'addlink'))?>
      </li>
    </ul>    
    <?php echo $session->flash(); ?> 
      
      <table id="master_categories"> </table>




</div>


<br class="clear" />
</div>
