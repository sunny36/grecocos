<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', array('controller' => 'dashboard', 
                                'action' => 'index'))); 
  ?> &rsaquo; 
  <?php 
    e($html->link('Products', array('controller' => 'products', 
                                'action' => 'index'))); 
  ?> &rsaquo;                            
  Add Product
</div>
<!-- End Navigation  -->

<div id="content" class="colM">
  <h1>Add product</h1>
  <div id="content-main">
    <?php echo $this->Form->create('Product', array('type' => 'file'));?>
  <div>
  <?php echo $session->flash(); ?>
  <fieldset class="module aligned ">
    <!-- Begin Id  -->
    <div class="form-row id">
      <div>
        <?php e($form->label('id', "User Id")); ?>        
        <strong> <?php e($user['User']['id']); ?></strong>
      </div>        
    </div>
    <!-- End Id  -->
    
    <!-- Begin First Name  -->
    <div class="form-row firstname">
      <div>
        <div>
          <?php e($form->label('firstname', "First Name")); ?>        
          <strong> <?php e($user['User']['firstname']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End First Name  -->
    
    <!-- Begin Middle Name  -->
    <div class="form-row firstname">
      <div>
        <div>
          <?php e($form->label('middlename', "Middle Name")); ?>        
          <strong> <?php e($user['User']['middlename']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Middle Name  -->
    
    <!-- Begin Last Name  -->
    <div class="form-row firstname">
      <div>
        <div>
          <?php e($form->label('lastname', "Last Name")); ?>        
          <strong> <?php e($user['User']['lastname']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Last Name  -->

    <!-- Begin Email  -->
    <div class="form-row email">
      <div>
        <div>
          <?php e($form->label('email', "Email")); ?>        
          <strong> <?php e($user['User']['email']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Email  -->

    <!-- Begin Address1  -->
    <div class="form-row address1">
      <div>
        <div>
          <?php e($form->label('address1', "Address1")); ?>        
          <strong> <?php e($user['User']['address1']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Address1  -->

    <!-- Begin Address2  -->
    <div class="form-row address2">
      <div>
        <div>
          <?php e($form->label('address2', "Address2")); ?>        
          <strong> <?php e($user['User']['address2']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Address2  -->

    <!-- Begin Address3  -->
    <div class="form-row address1">
      <div>
        <div>
          <?php e($form->label('address3', "Address3")); ?>        
          <strong> <?php e($user['User']['address3']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Address3  -->

    <!-- Begin City  -->
    <div class="form-row city">
      <div>
        <div>
          <?php e($form->label('city', "City")); ?>        
          <strong> <?php e($user['User']['city']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End City  -->

    <!-- Begin PostalCode  -->
    <div class="form-row postalcode">
      <div>
        <div>
          <?php e($form->label('postalcode', "PostalCode")); ?>        
          <strong> <?php e($user['User']['postalcode']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End PostalCode  -->
    
    <!-- Begin Status  -->
    <div class="form-row status">
      <div>
        <div>
          <?php e($form->label('status', "Status")); ?>        
          <strong> <?php e($user['User']['status']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Status  -->
    
    
</fieldset>

<div class="submit-row" >
  <?php echo $form->end(array('label' => 'Save', 'class' => 'default', 'div' => array('class' => false)));?>

</div>

</div>
</form></div>
        <br class="clear" />
    </div>
