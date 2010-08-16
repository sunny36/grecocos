<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', array('controller' => 'dashboard', 
                                'action' => 'index', 'admin' => true))); 
  ?> &rsaquo; 
  <?php 
    e($html->link('Users', array('controller' => 'users', 
                                'action' => 'index', 'admin' => true))); 
  ?> &rsaquo;                            
  View User
</div>
<!-- End Navigation  -->

<div id="content" class="colM">
  <h1>User Details</h1>
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

    <!-- Begin Phone  -->
    <div class="form-row email">
      <div>
        <div>
          <?php e($form->label('phone', "Phone")); ?>        
          <strong> <?php e($user['User']['phone']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Phone  -->

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


    <!-- Begin Status  -->
    <div class="form-row status">
      <div>
        <div>
          <?php e($form->label('delivery_address', "Delivery Address")); ?>        
          <strong> <?php e($user['Organization']['delivery_address']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Status  -->
    
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

    <!-- Begin Role  -->
    <div class="form-row status">
      <div>
        <div>
          <?php e($form->label('role', "Role")); ?>        
          <?php
            if ($user['User']['role'] == "admin") $role = "Administrator";
            if ($user['User']['role'] == "customer") $role = "Customer";
          ?>
          <strong> <?php e($role); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Role  -->
    
    
</fieldset>


</div>
</form></div>
        <br class="clear" />
    </div>
