<?php echo $html->css('users/signup.css', null, array('inline' => false)); ?>

<div id="content" class="colM">
  <h1>Signup</h1>
  <div id="content-main">
    <?php e($form->create('User', array('action' => 'signup')));?>
    <div>
      <?php echo $session->flash(); ?>
      <fieldset class="module aligned ">
        <!-- Begin Email  -->
        <div class="form-row email">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('User.email')) 
                e($form->error ('User.email', null, array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('email', "Email", array('class' => 'required'))); 
              e($form->text('email', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Email  -->

        <!-- Begin Password  -->
        <div class="form-row password">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('User.password2')) 
                e($form->error('User.password2', null, array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('password', "Password", array('class' => 'required'))); 
              e($form->password('password', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Password  -->

        <!-- Begin Password Confirmation  -->
        <div class="form-row password2">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('User.password2')) 
                e($form->error ('User.password2', null, array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('password2', "Password Confirmation", array('class' => 'required'))); 
              e($form->password('password2', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Password Confirmation  -->

        <!-- Begin First Name  -->
        <div class="form-row firstname">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('User.firstname')) 
                e($form->error ('User.firstname', null, array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('firstname', "First Name", array('class' => 'required'))); 
              e($form->text('firstname', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End First Name  -->

        <!-- Begin Middle Name  -->
        <div class="form-row middlename">
          <div>
            <?php 
              e($form->label('middlename', "Middle Name")); 
              e($form->text('middlename', array('class' => 'vTextField')));
            ?>        
          </div>
        </div>
        <!-- End Long Description  -->

        <!-- Begin Last Name  -->
        <div class="form-row lastname">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('User.lastname')) 
                e($form->error ('User.lastname', null, array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('lastname', "Last Name", array('class' => 'required'))); 
              e($form->text('lastname', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Last Name  -->
        
        <!-- Begin Delivery Address  -->    
        <div class="form-row organization_id">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('User.organization_id')) {
                e($form->error ('User.organization_id', null,  array('wrap' => 'li')));                 
              }
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('organization_id', "Delivery Address", array('class' => 'required')));
              e($form->select('organization_id', $delivery_addresses, NULL));
            ?>        
          </div>        
        </div>        
        <!-- End Delivery Address -->

        <!-- Begin Phone  -->
        <div class="form-row lastname">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('User.phone')) 
                e($form->error ('User.phone', null, array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('phone', "Phone", array('class' => 'required'))); 
              e($form->text('phone', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Phone  -->
        
      </fieldset>

      <div class="submit-row" >
        <?php 
          echo $form->end(array('label' => 'Signup', 'class' => 'default', 'div' => array('class' => false)));
        ?>
      </div>
    </div>
  </div>
  <br class="clear" />
</div>
