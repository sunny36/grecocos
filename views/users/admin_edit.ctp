<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php e($html->link('Home', array('controller' => 'dashboard', 
  'action' => 'index', 'admin' => true))); ?> 
  &rsaquo; 
  <?php e($html->link('Products', array('controller' => 'users', 
  'action' => 'index', 'admin' => true))); ?> 
  &rsaquo;                            
  Edit User
</div>
<!-- End Navigation -->

<div id="content" class="colM">
  <h1>Edit User</h1>
  <div id="content-main">
    <?php echo $this->Form->create('User');?>
    <div>
      <?php e($form->hidden('id'))?>
      <?php echo $session->flash(); ?>
      <fieldset class="module aligned ">

        <!-- Begin Email  -->
        <div class="form-row email">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('User.email')) 
                e($form->error ('User.email', null, 
                                array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('email', "Email", 
                             array('class' => 'required'))); 
                             e($form->text('email', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Email  -->

        <!-- Begin First Name  -->
        <div class="form-row firstname">
          <ul class="errorlist">
            <?php 
                               if($form->isFieldError('User.firstname')) 
                                 e($form->error ('User.firstname', null, 
                                                 array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('firstname', "Firstname", 
                             array('class' => 'required'))); 
                             e($form->text('firstname', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End First Name  -->

        <!-- Begin Last Name  -->
        <div class="form-row lastname">
          <ul class="errorlist">
            <?php 
                               if($form->isFieldError('User.lastname')) 
                                 e($form->error ('User.lastname', null, 
                                                 array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('lastname', "Last Name", 
                             array('class' => 'required'))); 
                             e($form->text('lastname', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Last Name  -->
        
        <!-- Begin Middle Name  -->
        <div class="form-row middlename">
          <div>
            <?php 
                               e($form->label('middlename', "Middle Name")); 
                               e($form->text('middlename', 
                                             array('class' => 'vTextField')));
            ?>        
          </div>
        </div>
        <!-- End Middle Name  -->

        <!-- Begin Delivery Address -->
        <div class="form-row delivery_address">
          <?php 
              $options=array('FAO RAP Bangkok' => 'FAO RAP Bangkok'); 
              e($form->label('delivery_address', 'Delivery Address', 
                             array('class' => 'required')));
              e($this->Form->select('delivery_address', $options, NULL, 
                                    array('empty' => false))); 
          ?>
        </div>
        <!-- End Delivery Address -->

        <!-- Begin City  -->
        <div class="form-row city">
          <ul class="errorlist">
            <?php 
                                 if($form->isFieldError('User.city')) 
                                   e($form->error ('User.city', null, 
                                                   array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('city', "City", 
                             array('class' => 'required'))); 
                             e($form->text('city', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End City  -->

        <!-- Begin Postal Code  -->
        <div class="form-row postalcode">
          <ul class="errorlist">
            <?php 
                               if($form->isFieldError('User.postalcode')) 
                                 e($form->error ('User.postalcode', null, 
                                                 array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('postalcode', "Postal Code", 
                             array('class' => 'required'))); 
                             e($form->text('postalcode', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Postal Code  -->

        <!-- Begin Phone  -->
        <div class="form-row phone">
          <ul class="errorlist">
            <?php 
                               if($form->isFieldError('User.phone')) 
                                 e($form->error ('User.phone', null, 
                                                 array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('phone', "Phone", 
                             array('class' => 'required'))); 
                             e($form->text('phone', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Phone  -->

        <!-- Begin Status -->
        <?php 
          $options=array($this->Form->value('User.status') => ucwords($this->Form->value('User.status')));
          if ($options[$this->Form->value('User.status')] != 'Accepted') {
            $options['accepted'] = 'Accepted';
          }
          
          if ($options[$this->Form->value('User.status')] != 'Deleted') {
            $options['deleted'] = 'Deleted';
          }
          if ($options[$this->Form->value('User.status')] != 'Registered') {
            $options['registered'] = 'Registered';
          }
        ?>  
        <div class="form-row">
          <?php
            echo $form->label('status', 'Status', array('class' => 'required'));
            echo $this->Form->select('status', $options, NULL, array('empty' => false)); 
            ?>
        </div>
        <!-- End Status -->


      </fieldset>
      
      <div class="submit-row" >
        <?php echo $form->end(array('label' => 'Save', 'class' => 'default', 'div' => array('class' => false)));?>

      </div>

    </div>
  </form>
</div>
<br class="clear" />
</div>
