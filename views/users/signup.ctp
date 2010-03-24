<h2>User Registration</h2>
<?php if($form->isFieldError('User.email')) 
        e($form->error ('User.email', null, array('class' => 'message'))); 
?>

<?php if($form->isFieldError('User.password')) 
        e($form->error ('User.password', null, array('class' => 'message'))); 
?>

<?php if($form->isFieldError('User.firstname')) 
        e($form->error ('User.firstname', null, array('class' => 'message'))); 
?>

<?php if($form->isFieldError('User.lastname')) 
        e($form->error ('User.lastname', null, array('class' => 'message'))); 
?>

<?php if($form->isFieldError('User.city')) 
        e($form->error ('User.city', null, array('class' => 'message'))); 
?>

<?php if($form->isFieldError('User.postalcode')) 
        e($form->error ('User.postalcode', null, array('class' => 'message'))); 
?>
<?php e($form->create('User', array('action' => 'signup')));?>
<fieldset>
  <div class="input text required">
    <?php e($form->label('email')); ?>
    <?php e($form->text('email', array('class' => 'fullwidth'))); ?>
  </div>
  <div class="input text required">
    <?php e($form->label('password')); ?>
    <?php e($form->password('password', array('class' => 'fullwidth'))); ?>
  </div>  
  <div class="input text required">
    <?php e($form->label('password confirmation')); ?>
    <?php e($form->password('password2', array('class' => 'fullwidth'))); ?>
  </div>
  <div class="input text required">
    <?php e($form->label('firtname')); ?>  
    <?php e($form->text('firstname', array('class' => 'fullwidth'))); ?>
  </div>
  <div class="input text">
    <?php e($form->label('middlename')); ?>  
    <?php e($form->text('middlename', array('class' => 'fullwidth'))); ?>
  </div>
  <div class="input text required">
    <?php e($form->label('lastname')); ?>  
    <?php e($form->text('lastname', array('class' => 'fullwidth'))); ?>
  </div>
  <div class="input text required">
    <?php e($form->label('address1')); ?>  
    <?php e($form->text('address1', array('class' => 'fullwidth'))); ?>
  </div>
  <div class="input text required">
    <?php e($form->label('address2')); ?>
    <?php e($form->text('address2', array('class' => 'fullwidth'))); ?>
  </div>
  <div class="input text required">
    <?php e($form->label('address3')); ?>
    <?php e($form->text('address3', array('class' => 'fullwidth'))); ?>
  </div>
  <div class="input text required">
    <?php e($form->label('city')); ?>
    <?php e($form->text('city', array('class' => 'fullwidth'))); ?>
  </div>
  <div class="input text required">
    <?php e($form->label('postalcode')); ?>
    <?php e($form->text('postalcode', array('class' => 'fullwidth'))); ?>
  </div>
  <div class="input text required">
    <?php e($form->label('phone')); ?>
    <?php e($form->text('phone', array('class' => 'fullwidth'))); ?>
  </div>
</fieldset>  
  <?php e($form->submit('Sign Up', array('div' => false, 'class' => 'submitbutton'))); ?>  
<?php e($form->end()); ?>
