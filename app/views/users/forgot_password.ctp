<style text="type/css">
.login #container {
  width: 30em;
}
.login .form-row label {
  width: 12em;
}
</style>
<?php echo $javascript->link('users/login.js', false); ?>
<div id="content" class="colM">
  <?php echo $session->flash(); ?>
  <div id="content-main">
    <?php e($form->create('User', array('action' => 'forgot_password')));?> 
      <?php e($form->hidden('id'))?>
      <div class="form-row">
        <label for="UserPassword">New Password:</label> 
        <?php e($form->password('password1', array('class' => 'fullwidth'))); ?>
      </div>
      <div class="form-row">
        <label for="UserPassword2">Confirm New Password:</label> 
        <?php e($form->password('password2', array('class' => 'fullwidth'))); ?>
      </div>
      <div class="submit-row">
        <?php e($form->submit('Change Password', array('div' => false, 
                                                'class' => 'submitbutton'))); ?>
        
      </div>
    <?php e($form->end()); ?>
    <br class="clear" />    
  </div>
</div>


