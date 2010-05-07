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
  Add Delivery Date
</div>
<!-- End Navigation  -->

<div id="content" class="colM">
  <h1>Add product</h1>
  <div id="content-main">
    <?php echo $this->Form->create('Delivery');?>
  <div>
  <?php echo $session->flash(); ?>
  <fieldset class="module aligned ">
    <!-- Begin Date  -->        
    <div class="form-row date">
      <div>
        <?php 
        e($form->label('date', "Date", 
                       array('class' => 'required')));
        e($this->Form->input('date', array('label' => false)));
        ?>        
      </div>        
    </div>    
    <!-- End Date  -->        

    <!-- Begin Date  -->        
    <div class="form-row date">
      <div>
        <?php 
        e($form->label('next_delivery', "Next Delivery?", 
                       array('class' => 'required')));
        e($form->checkbox('next_delivery', array('class' => 'vCheckBoxField')));
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