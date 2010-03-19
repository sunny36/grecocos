<h2>Log In </h2>

<?php 
         echo$this->Session->flash('auth'); 
      
?>

<?php e($form->create('User', array('action' => 'login')));?> 
<fieldset>
  <label for="UserEmail" class="emaillabel">
    <span>Email </span>
  </label>
  <?php e($form->text('email', array('class' => 'fullwidth'))); ?>
  
  <label for="UserPassword" class="passwordlabel">
    <span>Password </span>
  </label>
  <?php e($form->password('password', array('class' => 'fullwidth'))); ?>
  
  <?php e($form->submit('Login In', array('div' => false, 'class' => 'submitbutton'))); ?>
</fieldset> 
<?php e($form->end()); ?>