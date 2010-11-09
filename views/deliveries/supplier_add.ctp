<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('deliveries/supplier_deliveries_add.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>


<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', '/supplier')); 
  ?> &rsaquo; 
  <?php 
    e($html->link('Delivery Date', array('controller' => 'deliveries', 'action' => 'index'))); 
  ?> &rsaquo;                            
  Add Delivery Date
</div>
<!-- End Navigation  -->

<div id="content" class="colM">
  <h1>Add Delivery Date</h1>
  <div id="content-main">
    <?php echo $this->Form->create('Delivery');?>
    <?php 
      echo $form->hidden('date.month'); 
      echo $form->hidden('date.day'); 
      echo $form->hidden('date.year'); 
    ?>
    <div>
      <?php echo $session->flash(); ?>
      <fieldset class="module aligned ">
        <!-- Begin Date  -->        
        <div class="form-row date">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError("Delivery.date"))
                e($form->error('Delivery.date', null, array('wrap' => 'li'))); 
            ?>
          </ul>
          <div>
            <?php 
              e($form->label('date', "Date", 
                             array('class' => 'required')));
              e($form->text('date')); 
              ?>        
          </div>       


        </div>    
        <!-- End Date  -->        

      </fieldset>

      <div class="submit-row" >
        <?php echo $form->end(array('label' => 'Save', 'class' => 'default', 'div' => array('class' => false)));?>

      </div>

    </div>
  </form></div>
  <br class="clear" />
</div>
