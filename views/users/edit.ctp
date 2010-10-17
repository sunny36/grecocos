<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Shopping Cart', 
                  array('controller' => 'carts', 'action' => 'index'))); 
  ?> 
  &rsaquo; 
  Edit Profile
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

        <!-- Begin Delivery Address  -->    
        <div class="form-row organization_id">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('User.organization_id')) 
                e($form->error ('User.organization_id', null, 
                                array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('organization_id', "Delivery Address",
                             array('class' => 'required')));
              e($form->select('organization_id', $delivery_addresses, NULL, 
                              array('empty' => false)));
            ?>        
          </div>        
        </div>        
        <!-- End Delivery Address -->


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

      </fieldset>
      
      <div class="submit-row" >
        <?php echo $form->end(array('label' => 'Save', 'class' => 'default', 'div' => array('class' => false)));?>

      </div>

    </div>
  </form>
</div>
<br class="clear" />
</div>
