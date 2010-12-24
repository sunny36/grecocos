<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('deliveries/supplier_deliveries_add.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>

<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', array('controller' => 'dashboard', 
                                'action' => 'index'))); 
  ?> &rsaquo; 
  <?php 
    e($html->link('Delivery Date', array('controller' => 'deliveries', 
                                'action' => 'index'))); 
  ?> &rsaquo;                            
  Edit Delivery Date
</div>
<!-- End Navigation  -->

<div id="content" class="colM">
  <h1>Add product</h1>
  <div id="content-main">
    <?php echo $this->Form->create('Delivery');?>
    <?php echo $form->hidden('id'); ?>
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

    <!-- Begin Next Delivery  -->        
    <div class="form-row date">
      <div>
        <?php 
        e($form->label('next_delivery', "Next Delivery?", 
                       array('class' => 'required')));
        e($form->checkbox('next_delivery', array('class' => 'vCheckBoxField')));
        ?>        
      </div>        
    </div>    
    <!-- End Next Delivery  -->        

     
 </fieldset>

<div class="submit-row" >
  <p class="deletelink-box">
    <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Delivery.id')), array('class' => 'deletelink'), sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Delivery.id'))); ?>

  </p>
	
 
  <?php echo $form->end(array('label' => 'Save', 'class' => 'default', 'div' => array('class' => false)));?>

</div>

</div>
</form></div>
        <br class="clear" />
    </div>
