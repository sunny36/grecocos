<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('util.js', false); ?>
<?php echo $javascript->link('configurations.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>


<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', '/coordinator')); 
  ?> &rsaquo; 
  Configuration
</div>
<!-- End Navigation  -->

<div id="content" class="colM">
  <h1>Configurations</h1>
  
  <div id="content-main">
    <?php echo $session->flash(); ?>
    <?php echo $this->Form->create('Configuration');?>
    <div>
      <?php echo $session->flash(); ?>
      <fieldset class="module aligned ">
        <!-- Begin Closed  -->        
        <div class="form-row date">
          <div>
            <?php 
              e($form->label('closed', "System Closed", array('class' => 'required')));
              $options=array('yes'=>'Yes','no'=>'No');
              echo $form->select('closed', $options, array('selected' => $closed), array('empty' => false));
              ?>        
          </div>       
        </div>    
        <!-- End Closed  -->        

      </fieldset>

      <div class="submit-row" >
        <?php echo $form->end(array('label' => 'Save', 'class' => 'default', 'div' => array('class' => false)));?>

      </div>

    </div>
  </form></div>
  <br class="clear" />
</div>
