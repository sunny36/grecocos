<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.2.custom.min', false); ?>
<?php echo $javascript->link('jquery.wysiwyg.js', false); ?>
<?php // echo $javascript->link('emails/index.js', false); ?>
<?php echo $html->css('jquery-ui/redmond/jquery-ui-1.8.2.custom', null, array('inline' => false)); ?>
<?php echo $html->css('jquery.wysiwyg', null, array('inline' => false)); ?>
<style>
form .aligned p, form .aligned ul {
  margin-left: 0;
}
#content-main {
  width: 50%;
}
input.default[type="submit"] {
float:left;
}
</style>
<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php e($html->link('Home', '/supplier')); ?> 
  &rsaquo;                            
  Send Emails
</div>

<div id="content" class="colM">
  <h1>Send Emails</h1>
  <div id="content-main">
    <?php e($this->Form->create('Email', array('action' => 'index')));?>
    <div>
      <?php echo $session->flash(); ?>
      <fieldset class="module aligned ">
        <!-- Begin To  -->
        <div class="form-row short_description">
          <?php e($form->label('to', "To", array('class' => 'required')));?>        
          <h4>All Registered Customers</h4>
        </div>
        <!-- End To  -->
        
        <!-- Begin Subject  -->
        <div class="form-row short_description">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('Email.subject')) e($form->error ('Email.subject', null, array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('subject', "Subject", array('class' => 'required'))); 
              e($form->text('subject', array('class' => 'vMediumTextField', 'size' => '100')));
            ?>                    
          </div>
        </div>
        <!-- End Subject  -->
        
        <!-- Begin Body  -->
        <div class="form-row long_description">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('Email.body')) e($form->error ('Email.body', null, array('wrap' => 'li'))); 
            ?>
          </ul>                
          <div>
            <?php 
               e($form->label('body', "Message", array('class' => 'required'))); 
               e($form->textarea('body', array('rows' => "20", 'cols' => "80")));
            ?>        
          </div>
        </div>
        <!-- End Body  -->
      </fieldset>
      <div class="submit-row" >
        <?php 
          echo $form->end(array('label' => 'Send', 'class' => 'default', 'div' => array('class' => false)));
        ?>
      </div>

    </div>
  </div>
  <br class="clear" />
</div>
