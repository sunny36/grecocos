<h2>User Registration</h2>

<?php if($form->isFieldError('User.username')) 
        e($form->error ('User.username', null, array('class' => 'message'))); 
?>
<?php if($form->isFieldError('User.password')) 
        e($form->error ('User.password', null, array('class' => 'message'))); 
?>
<?php if($form->isFieldError('User.email')) 
        e($form->error ('User.email', null, array('class' => 'message'))); 
?>

<?php e($form->create('User', array('action' => 'signup')));?>
<fieldset>
  <label for="UserUsername" class="usernamelabel">
    <span>Username </span>
  </label>
  <?php e($form->text('username', array('class' => 'fullwidth'))); ?>
  
  <label for="UserEmail" class="emaillabel">
    <span>Email </span>
  </label>
  <?php e($form->text('email', array('class' => 'fullwidth'))); ?>
  
  <label for="UserPassword" class="passwordlabel">
    <span>Password</span>
  </label>
  <?php e($form->password('password', array('class' => 'fullwidth'))); ?>
  
  <label for="UserPasswordRepeat" class="passwordrepeatlabel">
    <span> Password Confirmation</span>
  </label>
  <?php e($form->password('password2', array('class' => 'fullwidth'))); ?>
  
  <label for="UserFirstname" class="firstnamelabel">
    <span>First Name </span>
  </label>
  <?php e($form->text('firstname', array('class' => 'fullwidth'))); ?>

  <label for="UserMiddlename" class="middlenamelabel">
    <span>Middle Name </span>
  </label>
  <?php e($form->text('middlename', array('class' => 'fullwidth'))); ?>

  <label for="UserLastname" class="lastnamelabel">
    <span>Last Name </span>
  </label>
  <?php e($form->text('lastname', array('class' => 'fullwidth'))); ?>

  <label for="UserAddress1" class="address1label">
    <span>Address1 </span>
  </label>
  <?php e($form->text('address1', array('class' => 'fullwidth'))); ?>

  <label for="UserAddress2" class="address2label">
    <span>Address2 </span>
  </label>
  <?php e($form->text('address2', array('class' => 'fullwidth'))); ?>

  <label for="UserAddres3" class="address3label">
    <span>Address3 </span>
  </label>
  <?php e($form->text('address3', array('class' => 'fullwidth'))); ?>

  <label for="UserCity" class="citylabel">
    <span>City </span>
  </label>
  <?php e($form->text('city', array('class' => 'fullwidth'))); ?>

  <label for="UserPostalcode" class="postalcodelabel">
    <span>Postal Code </span>
  </label>
  <?php e($form->text('postalcode', array('class' => 'fullwidth'))); ?>

  <label for="UserPhone" class="phonelabel">
    <span>Phone </span>
  </label>
  <?php e($form->text('phone', array('class' => 'fullwidth'))); ?>

  
  <?php e($form->submit('Sign Up', 
          array('div' => false, 'class' => 'submitbutton'))); ?>  
</fieldset>
<?php e($form->end()); ?>
